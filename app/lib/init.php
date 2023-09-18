<?php
declare(strict_types=1);
namespace s9com;


$APP_DIR = realpath(__DIR__.'/..');


require $APP_DIR.'/conf.php';


if ($conf['maintenance_mode']) {
    include $conf['page_dir'].'/_maintenance.php';
    exit(0);
}


require $APP_DIR.'/lib/core.php';
require $APP_DIR.'/lib/database.php';
require $APP_DIR.'/lib/router.php';
require $APP_DIR.'/lib/logger.php';


// Set some php settings
error_reporting($conf['error_reporting_level']);
date_default_timezone_set($conf['site_timezone']);


// Init database and open database for reading
$DB = new Database($conf['db_file']);
$DB->open(rw: false);


// Load version data
require $conf['version_file'];


// Load valid requests data
require $conf['valid_requests_file'];


// Init router and parse current request/route
$Router = new Router($valid_requests);
$Router->parse_route();


// Validate current parsed request
if ($conf['validate_requests']) {
    $Router->validate_request();
}


// Process pre-render settings
$node_middleware_files = [];
$node_page_files = [];

$node_settings = $conf['pre_render_settings'][$Router->route['node']];

if ($node_settings['headers']) {
    foreach ($node_settings['headers'] as $v) {
        header($v);
    }
}

if ($node_settings['middleware_files']) {
    foreach ($node_settings['middleware_files'] as $v) {
        $node_middleware_files[] = $APP_DIR.'/'.$v;
    }
}

if ($node_settings['page_files']) {
    $node_page_files = $node_settings['page_files'];
}


// Init logger
$Logger = new Logger($conf['log_dir']);


// Init app
foreach ($node_middleware_files as $v) {
    require $v;
}

// FIXME: still can have only one Page class at once
if (!class_exists('\s9com\Page')) {
    $App = new Core($conf, $version, $DB, $Router, $Logger);
}
else {
    $App = new Page($conf, $version, $DB, $Router, $Logger);
}

// Janitor
unset(
    $conf, // from conf.php
    $version, // from version_file
    $valid_requests, // from valid_requests_file
    $DB,
    $Router,
    $Logger,
    $node_middleware_files,
    $node_settings,
);


// Render output
$App->render_output($node_page_files);
