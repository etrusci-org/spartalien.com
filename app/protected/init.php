<?php
foreach (glob(__DIR__.'/lib/vendor/*.php') as $v) {
    require_once $v;
}

require_once __DIR__.'/conf.php';
require_once __DIR__.'/lib/app.php';
require_once __DIR__.'/cache/validrequests.php'; # run app/protected/gen-validrequests.php to generate this file

$App = new App($conf);
$App->validateRequest();
$App->renderOutput();
