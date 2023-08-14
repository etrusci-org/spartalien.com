#!/usr/bin/env php
<?php
declare(strict_types=1);
namespace s9com;


$APP_DIR = realpath(__DIR__.'/app');


require $APP_DIR.'/conf.php';
require $APP_DIR.'/lib/mixcloud.php';


$Mixcloud = new MixcloudData();
$Mixcloud->cacheDir = $conf['cache_dir'];
$Mixcloud->errorFile = $conf['log_dir'].'/mixcloud-error.log';
$Mixcloud->requestDelay = 1.0;
$Mixcloud->pagingLimit = 100;
// print_r($Mixcloud);


$Mixcloud->getUser('lowtechman');
$Mixcloud->getCloudcasts('lowtechman');


print(microtime(true).' baked mixcloud ('.array_sum(array_map(function(string $v): int { return filesize($v); }, glob($conf['cache_dir'].'/mixcloud-*'))).' bytes)'.PHP_EOL);
