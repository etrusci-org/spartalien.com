#!/usr/bin/env php
<?php
declare(strict_types=1);
namespace s9com;


$APP_DIR = realpath(__DIR__.'/app');


require $APP_DIR.'/conf.php';


$dump = '';

$dump .= "'db' => ".filemtime($conf['db_file']).",".PHP_EOL;

$dump .= "'css' => ".array_sum(
    array_map(function(string $v): int {
        return filemtime($v);
    }, glob($APP_DIR.'/public/res/*.css'))).",".PHP_EOL;

$dump .= "'js' => ".array_sum(
    array_map(function(string $v): int {
        return filemtime($v);
    }, glob($APP_DIR.'/public/res/*.js'))).",".PHP_EOL;

$dump .= "'og' => ".filemtime($APP_DIR.'/public/res/og.jpg').",".PHP_EOL;

$dump .= "'favicon' => ".filemtime($APP_DIR.'/public/favicon.ico').",".PHP_EOL;

$dump = '<?php $version = ['.PHP_EOL.$dump.']; ?>';

file_put_contents($conf['version_file'], $dump, LOCK_EX);

print(microtime(true).' baked version ('.filesize($conf['version_file']).' bytes)'.PHP_EOL);
