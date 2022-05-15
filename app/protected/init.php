<?php
require_once __DIR__.'/lib/vendor/WebApp.php';
require_once __DIR__.'/lib/vendor/WebRouter.php';
require_once __DIR__.'/lib/vendor/DatabaseSQLite3.php';
require_once __DIR__.'/lib/vendor/jdec.php';
require_once __DIR__.'/lib/vendor/hsc5.php';
// require_once __DIR__.'/lib/vendor/hsc5print.php';

require_once __DIR__.'/conf.php';
require_once __DIR__.'/lib/app.php';

$App = new App($conf);
$App->renderOutput();
