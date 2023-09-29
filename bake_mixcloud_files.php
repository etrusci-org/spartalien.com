#!/usr/bin/env php
<?php
declare(strict_types=1);
namespace s9com;


$APP_DIR = realpath(__DIR__.'/app');


require $APP_DIR.'/conf.php';
require $APP_DIR.'/lib/mixcloud.php';


$Mixcloud = new Mixcloud();
$Mixcloud->cache_dir = $conf['cache_dir'];

$Mixcloud->fetch_cloudcasts('lowtechman');
$Mixcloud->fetch_user('lowtechman');


print(microtime(true).' baked mixcloud ('.array_sum(array_map(function(string $v): int { return filesize($v); }, glob($conf['cache_dir'].'/mixcloud-*'))).' bytes)'.PHP_EOL);
