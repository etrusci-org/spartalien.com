<?php
declare(strict_types=1);
namespace s9com;
use \SQLite3;
use \SQLite3Result;


class Database
{
    protected SQLite3 $DB;
    protected string  $db_file;
    protected string  $sqlite_version;


    public function __construct(string $db_file)
    {
        $this->db_file = $db_file;
        $this->sqlite_version = SQLite3::version()['versionString'];
    }


    public function open(bool $rw = false): bool
    {
        $flag = (!$rw) ? SQLITE3_OPEN_READONLY : SQLITE3_OPEN_READWRITE;

        $this->DB = new SQLite3($this->db_file, $flag);

        if (!($this->DB instanceof SQLite3)) return false;

        return true;
    }


    public function close(): bool
    {
        if (!($this->DB instanceof SQLite3)) return false;

        $this->DB->close();

        return true;
    }


    public function query(string $query, array $values = []): array|false
    {
        if (!($this->DB instanceof SQLite3)) return false;

        $stmt = $this->DB->prepare($query);
        if (!$stmt) return false;

        foreach ($values as $v) {
            $stmt->bindValue($v[0], $v[1], $v[2]);
        }

        $result = $stmt->execute();
        if (!$result) return false;

        $dump = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $dump[] = $row;
        }

        $stmt->close();

        return $dump;
    }


    public function query_single(string $query, array $values = []): array|false
    {
        if (!($this->DB instanceof SQLite3)) return false;

        $result = $this->query($query, $values);

        if (!$result || count($result) < 1) {
            return false;
        }

        return $result[0];
    }


    public function write(string $query, array $values = []): SQLite3Result|false
    {
        if (!($this->DB instanceof SQLite3)) return false;

        $stmt = $this->DB->prepare($query);

        if (!$stmt) return false;

        foreach ($values as $v) {
            $stmt->bindValue($v[0], $v[1], $v[2]);
        }

        return $stmt->execute();
    }
}
