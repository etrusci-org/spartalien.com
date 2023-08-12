<?php
declare(strict_types=1);
namespace s9com;


$conf = [];

// ----------------------------------------------------------------------------

$conf['site_title'] = 'SPARTALIEN';
$conf['site_url_scheme'] = 'http';
$conf['site_domain'] = 'localhost';
$conf['site_dir']    = '/spartalien.com/app/public/';
$conf['site_url']    = $conf['site_url_scheme'].'://'.$conf['site_domain'].$conf['site_dir'];
$conf['site_timezone'] = 'Europe/Zurich';

// ----------------------------------------------------------------------------

$conf['error_reporting_level'] = E_ALL;

// ----------------------------------------------------------------------------

$conf['db_file'] = $APP_DIR.'/db/main.sqlite3';
$conf['cache_dir'] = $APP_DIR.'/cache';
$conf['log_dir'] = $APP_DIR.'/log';
$conf['page_dir'] = $APP_DIR.'/page';
$conf['version_file'] = $conf['cache_dir'].'/version.php';
$conf['valid_requests_file'] = $APP_DIR.'/cache/valid_requests.php';

// ----------------------------------------------------------------------------

$conf['caching_ttl'] = -1;
$conf['validate_requests'] = true;

// ----------------------------------------------------------------------------
// Valid request patterns
// We don't have to put a pattern for node=home (the default route)
// here since this is an empty request string and will be validated
// correctly in Router::validate_request().
// Same applies to Router::error_node.

$conf['valid_request_patterns'] = [
    // [
    //     'route' => '/^about$/',
    //     'valuesTable' => '',
    //     'valuesCol' => [],
    // ],
    [
        'route' => '/^catalog$/',
        'valuesTable' => '',
        'valuesCol' => [],
    ],
    [
        'route' => '/^music$/',
        'valuesTable' => '',
        'valuesCol' => [],
    ],
    [
        'route' => '/^music\/id:{val1}$/',
        'valuesTable' => 'rls',
        'valuesCol' => [
            'val1' => 'id',
        ],
    ],
];

// ----------------------------------------------------------------------------
// Node specific pre render settings

$conf['pre_render_settings'] = [
    'error404' => [
        'class_file' => '',
        'headers' => [],
        'page_files' => [],
    ],
    'home' => [
        'class_file' => '',
        'headers' => [],
        'page_files' => [],
    ],
    // 'about' => [
    //     'class_file' => '',
    //     'headers' => [],
    //     'page_files' => [],
    // ],
    'catalog' => [
        'class_file' => 'audio',
        'headers' => [],
        'page_files' => [],
    ],
    'music' => [
        'class_file' => 'audio',
        'headers' => [],
        'page_files' => [],
    ],
    // 'news.atom' => [
    //     'class_file' => '',
    //     'headers' => [
    //         'Content-Type: application/atom+xml; charset=utf-8'
    //     ],
    //     'page_files' => ['_header_news.atom', '*node', '_footer_news.atom']
    // ],
];

// ----------------------------------------------------------------------------
// Session stuff

// $conf['session_key'] = 'com.spartalien.v9.1';

// $conf['session_options'] = [
//     'cookie_lifetime' => 86400 * 365 * 1000,
//     'cookie_domain'   => $conf['site_domain'],
//     'cookie_path'     => $conf['site_dir'],
//     'cookie_secure'   => ($conf['site_url_scheme'] != 'https') ? false : true,
//     'cookie_httponly' => true,
//     'cookie_samesite' => 'Strict',
// ];

// $conf['session_default'] = [
//     'nickname' => null,
// ];

// ----------------------------------------------------------------------------
// Template stuff

$conf['default_css_file'] = './res/style.min.css';
