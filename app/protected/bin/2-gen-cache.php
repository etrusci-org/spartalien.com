<?php
require __DIR__.'/../conf.php';
require_once __DIR__.'/../cache/validrequests.php';

// if (!$conf['cachingEnabled']) {
//     print('$conf[cachingEnabled] must be true for this to work');
if (APP_MODE_PRODUCTION !== true) {
    print('APP_MODE_PRODUCTION must be true for this to work');
    exit(1);
}

print('priming cache...'.PHP_EOL);

$scriptStart = microtime(TRUE);

$c = 0;
foreach (VALID_REQUESTS as $v) {
    // $url = $conf['baseURL'].$v;
    $url = 'http://localhost/spartalien.com/app/public/'.$v; // HACK: FIXME: JESUS CHRIST!
    $data = file_get_contents($url);
    $c += 1;
    print($url.PHP_EOL);
}

printf('done caching %d routes in %f seconds'.PHP_EOL, $c, (microtime(TRUE) - $scriptStart));