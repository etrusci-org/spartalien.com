<?php
declare(strict_types=1);
namespace s9com;


class Logger
{
    public string $log_dir;
    public string $current_log_file;


    public function __construct(string $log_dir)
    {
        $this->log_dir = $log_dir;
        $this->current_log_file = $log_dir.'/'.date('Y-m-d').'.log';
    }


    public function log(string $message): void
    {
        $line = microtime(true)
                .' | '.date('Y-m-d H:i:s T')
                .' | '.$message
                .' | '.($_SERVER['REQUEST_URI'] ?? 'unknown')
                .' | client_ip_hash='.hash('ripemd160', $this->_get_client_ip())
                .' | client_agent='.($_SERVER['HTTP_USER_AGENT'] ?? 'unknown')
                .PHP_EOL;

        file_put_contents($this->current_log_file, $line, FILE_APPEND);
    }


    private static function _get_client_ip(): string|null
    {
        $ip = null;

        if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        // HTTP_X_FORWARDED_FOR usually contains more than one ip: client, proxy1, proxy2, ..., but we only want the client ip.
        if (is_string($ip) && strstr($ip, ',')) {
            $dump = explode(',', $ip);
            if (is_array($dump) && isset($dump[0])) {
                $ip = trim($dump[0]);
            }
        }

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            $ip = null;
        }

        return $ip;
    }
}
