<?php
declare(strict_types=1);
namespace s9com;


$APP_DIR = realpath(__DIR__.'/..');


require $APP_DIR.'/conf.php';
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
$node_page_class_file = null;
$node_page_files = null;

$node_settings = $conf['pre_render_settings'][$Router->route['node']];

if ($node_settings['headers']) {
    foreach ($node_settings['headers'] as $v) {
        header($v);
    }
}

if ($node_settings['class_file']) {
    $node_page_class_file = $conf['page_dir'].'/_'.$node_settings['class_file'].'.class.php';
}

if ($node_settings['page_files']) {
    $node_page_files = $node_settings['page_files'];
}


// Init logger
$Logger = new Logger($conf['log_dir']);


// Init app
if (!$node_page_class_file) {
    $App = new Core($conf, $version, $DB, $Router, $Logger);
}
else {
    require $node_page_class_file;
    $App = new Page($conf, $version, $DB, $Router, $Logger);
}


// Janitor
unset(
    $conf, // from conf.php
    $version, // from version_file
    $valid_requests, // from valid_requests_file
    $DB, // DB
    $Router, // Router
    $Logger, // Logger
);


// Render output
$App->render_output($node_page_files);
