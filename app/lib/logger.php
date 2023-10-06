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
        $line = microtime(true).' | '.date('Y-m-d H:i:s T').' | '.$message.PHP_EOL;
        file_put_contents($this->current_log_file, $line, LOCK_EX | FILE_APPEND);
    }
}
