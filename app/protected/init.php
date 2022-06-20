<?php
require_once __DIR__.'/lib/vendor/DatabaseSQLite3.php';
// require_once __DIR__.'/lib/vendor/hsc5.php';
require_once __DIR__.'/lib/vendor/jdec.php';
require_once __DIR__.'/lib/vendor/jenc.php';
require_once __DIR__.'/lib/vendor/WebApp.php';
require_once __DIR__.'/lib/vendor/WebRouter.php';

require_once __DIR__.'/conf.php';
require_once __DIR__.'/lib/app.php';
require_once __DIR__.'/cache/validrequests.php'; # run app/protected/gen-validrequests.php to generate this file

$App = new App($conf);
$App->validateRequest();
$App->renderOutput();
