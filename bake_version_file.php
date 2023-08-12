#!/usr/bin/env php
<?php
declare(strict_types=1);
namespace s9com;


$APP_DIR = realpath(__DIR__.'/app');


require $APP_DIR.'/conf.php';


$dump = [];

$dump[] = "'css' => ".array_sum(
    array_map(function(string $v): int {
        return filemtime($v);
    }, glob($APP_DIR.'/public/res/*.css')));

$dump[] = "'js' => ".array_sum(
    array_map(function(string $v): int {
        return filemtime($v);
    }, glob($APP_DIR.'/public/res/*.js')));

$dump = sprintf('<?php $version = [%s]; ?>'.PHP_EOL, implode(', ', $dump));

file_put_contents($conf['version_file'], $dump, LOCK_EX);

print(microtime(true).' baked version ('.filesize($conf['version_file']).' bytes)'.PHP_EOL);
