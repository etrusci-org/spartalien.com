<?php
declare(strict_types=1);
namespace s9com;
use SQLite3;
use SQLite3Result;


class ActiveVisitors
{
    private SQLite3 $DB;


    public function __construct(
        private string $db_file ='data/database.sqlite3',
        private int $timeout_after = 60 * 15,
        private string $hash_algo = 'ripemd160',
        private bool $testmode = false,
    )
    {
        $this->DB = new SQLite3(filename: $db_file, flags: SQLITE3_OPEN_READWRITE);
    }


    public function get_activity(): SQLite3Result|false
    {
        return $this->db_query('SELECT client_hash, last_seen, last_location FROM activity ORDER BY last_seen DESC;');
    }


    public function log_activity(): void
    {
        $time_now = time();
        $current_location = $_SERVER['REQUEST_URI'] ?? null;
        $client_hash = $this->get_current_client_hash();

        $this->db_query('
            INSERT INTO activity (client_hash, last_seen, last_location)
            VALUES (:client_hash, :last_seen, :last_location)
            ON CONFLICT (client_hash) DO UPDATE SET last_seen = :last_seen, last_location = :last_location;',
            [
                ['client_hash', $client_hash, SQLITE3_TEXT],
                ['last_seen', $time_now, SQLITE3_INTEGER],
                ['last_location', $current_location, SQLITE3_TEXT],
            ]
        );

        $this->db_query('
            DELETE FROM activity
            WHERE :time_now - last_seen > :timeout_after;',
            [
                ['time_now', $time_now, SQLITE3_INTEGER],
                ['timeout_after', $this->timeout_after, SQLITE3_INTEGER],
            ]
        );
    }


    private function db_query(string $query, array $values = []): SQLite3Result|false
    {
        $stmt = $this->DB->prepare($query);

        if ($stmt === false) return false;

        foreach ($values as $v) {
            $stmt->bindValue($v[0], $v[1], $v[2]);
        }

        return $stmt->execute();
    }


    private function get_current_client_hash(): string
    {
        if ($this->testmode === true) {
            $dump = ['a', 'b', 'c', 'd'];
            return $this->hash_value($dump[array_rand($dump)]);
        }

        $ip = null;
        if (isset($_SERVER['REMOTE_ADDR'])) $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        // HTTP_X_FORWARDED_FOR usually contains more than one ip: client, proxy1, proxy2, ..., but we only want the client ip.
        if (is_string($ip) && strstr($ip, ',')) {
            $dump = explode(',', $ip);
            $ip = trim($dump[0]);
        }
        if (!filter_var($ip, FILTER_VALIDATE_IP)) $ip = 'noip';

        $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'noagent';

        return $this->hash_value($ip.$agent);
    }


    private function hash_value(string $data): string
    {
        return hash_hmac(algo: $this->hash_algo, data: strtolower($data), key: 'activevisitors-'.date('z'));
    }
}
