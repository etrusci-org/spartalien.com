<?php
require_once __DIR__.'/lib/vendor/WebRouter.php';
require_once __DIR__.'/lib/vendor/WebApp.php';
require_once __DIR__.'/lib/vendor/DatabaseSQLite3.php';
require_once __DIR__.'/lib/vendor/MixcloudData.php';
require_once __DIR__.'/lib/vendor/jsonDecode.php';
require_once __DIR__.'/lib/vendor/jsonEncode.php';

require_once __DIR__.'/conf.php';
require_once __DIR__.'/version.php';
require_once __DIR__.'/lib/app.php';
require_once __DIR__.'/cache/validrequests.php'; # run app/protected/gen-validrequests.php to generate this file

date_default_timezone_set($conf['timezone']);

$App = new App($conf);
$App->validateRequest();


$openDB = false;
foreach ($conf['preRenderSettings'] as $node => $nodeSettings) {

    if ($node == $App->route['node']) {

        if (isset($nodeSettings['headers'])) {
            foreach ($nodeSettings['headers'] as $v) {
                header($v);
            }
        }

        if (isset($nodeSettings['openDB'])) {
            $openDB = $nodeSettings['openDB'];
        }
    }

}


$App->renderOutput(openDB: $openDB);
