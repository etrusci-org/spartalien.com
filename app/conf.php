<?php
declare(strict_types=1);
namespace s9com;


$conf = [];

// ----------------------------------------------------------------------------

$conf['maintenance_mode'] = false;
$conf['error_reporting_level'] = E_ALL;

// ----------------------------------------------------------------------------

$conf['site_title'] = 'SPARTALIEN';
$conf['site_url_scheme'] = 'http';
$conf['site_domain'] = 'localhost';
$conf['site_dir'] = '/spartalien.com/app/public/';
$conf['site_url'] = $conf['site_url_scheme'].'://'.$conf['site_domain'].$conf['site_dir'];
$conf['site_timezone'] = 'UTC';
$conf['site_nav'] = [
    'home' => [
        'link' => './',
        'link_text' => 'home',
    ],
    'music' => [
        'link' => './music',
        'link_text' => 'music',
    ],
    'catalog' => [
        'link' => './catalog',
        'link_text' => 'catalog',
    ],
    'visual' => [
        'link' => './visual',
        'link_text' => 'visual',
    ],
    'physical' => [
        'link' => './physical',
        'link_text' => 'physical',
    ],
    'planet420' => [
        'link' => './planet420',
        'link_text' => 'planet420',
    ],
    'mixtape' => [
        'link' => './mixtape',
        'link_text' => 'mixtape',
    ],
    'tool' => [
        'link' => './tool',
        'link_text' => 'tool',
    ],
    'stuff' => [
        'link' => './stuff',
        'link_text' => 'stuff',
    ],
    'mention' => [
        'link' => './mention',
        'link_text' => 'mention',
    ],
    'news' => [
        'link' => './news',
        'link_text' => 'news',
    ],
    'about' => [
        'link' => './about',
        'link_text' => 'about',
    ],
    'exit' => [
        'link' => './exit',
        'link_text' => 'exit',
    ],
];

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
    [
        'route' => '/^about$/',
        'valuesTable' => '',
        'valuesCol' => [],
    ],
    [
        'route' => '/^catalog$/',
        'valuesTable' => '',
        'valuesCol' => [],
    ],
    [
        'route' => '/^catalog\/track:{val1}$/',
        'valuesTable' => 'track',
        'valuesCol' => [
            'val1' => 'id',
        ],
    ],
    [
        'route' => '/^catalog\/artist:{val1}$/',
        'valuesTable' => 'artist',
        'valuesCol' => [
            'val1' => 'id',
        ],
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
    [
        'route' => '/^physical$/',
        'valuesTable' => '',
        'valuesCol' => [],
    ],
    [
        'route' => '/^physical\/id:{val1}$/',
        'valuesTable' => 'phy',
        'valuesCol' => [
            'val1' => 'id',
        ],
    ],
    [
        'route' => '/^visual$/',
        'valuesTable' => '',
        'valuesCol' => [],
    ],
    [
        'route' => '/^visual\/id:{val1}$/',
        'valuesTable' => 'visual',
        'valuesCol' => [
            'val1' => 'id',
        ],
    ],
    [
        'route' => '/^tool$/',
        'valuesTable' => '',
        'valuesCol' => [],
    ],
    [
        'route' => '/^stuff$/',
        'valuesTable' => '',
        'valuesCol' => [],
    ],
    [
        'route' => '/^stuff\/id:{val1}$/',
        'valuesTable' => 'stuff',
        'valuesCol' => [
            'val1' => 'id',
        ],
    ],
    [
        'route' => '/^mixtape$/',
        'valuesTable' => '',
        'valuesCol' => [],
    ],
    [
        'route' => '/^news$/',
        'valuesTable' => '',
        'valuesCol' => [],
    ],
    [
        'route' => '/^news\/id:{val1}$/',
        'valuesTable' => 'news',
        'valuesCol' => [
            'val1' => 'id',
        ],
    ],
    [
        'route' => '/^mention$/',
        'valuesTable' => '',
        'valuesCol' => [],
    ],
    [
        'route' => '/^mention\/id:{val1}$/',
        'valuesTable' => 'mention',
        'valuesCol' => [
            'val1' => 'id',
        ],
    ],
    [
        'route' => '/^planet420$/',
        'valuesTable' => '',
        'valuesCol' => [],
    ],
    [
        'route' => '/^planet420\/session:{val1}$/',
        'valuesTable' => 'p420_session',
        'valuesCol' => [
            'val1' => 'num',
        ],
    ],
    [
        'route' => '/^exit$/',
        'valuesTable' => '',
        'valuesCol' => [],
    ],
];

// ----------------------------------------------------------------------------
// Node specific pre render settings

$conf['pre_render_settings'] = [
    'error404' => [
        'headers' => [],
        'middleware_files' => [],
        'page_files' => [],
    ],
    'home' => [
        'headers' => [],
        'middleware_files' => [],
        'page_files' => [],
    ],
    'about' => [
        'headers' => [],
        'middleware_files' => [],
        'page_files' => [],
    ],
    'catalog' => [
        'headers' => [],
        'middleware_files' => ['page/_music.class.php'],
        'page_files' => [],
    ],
    'music' => [
        'headers' => [],
        'middleware_files' => ['page/_music.class.php'],
        'page_files' => [],
    ],
    'physical' => [
        'headers' => [],
        'middleware_files' => ['page/_physical.class.php'],
        'page_files' => [],
    ],
    'visual' => [
        'headers' => [],
        'middleware_files' => ['page/_visual.class.php'],
        'page_files' => [],
    ],
    'tool' => [
        'headers' => [],
        'middleware_files' => [],
        'page_files' => [],
    ],
    'stuff' => [
        'headers' => [],
        'middleware_files' => ['page/_stuff.class.php'],
        'page_files' => [],
    ],
    'mixtape' => [
        'headers' => [],
        'middleware_files' => [],
        'page_files' => [],
    ],
    'news' => [
        'headers' => [],
        'middleware_files' => ['page/_news.class.php'],
        'page_files' => [],
    ],
    'mention' => [
        'headers' => [],
        'middleware_files' => ['page/_mention.class.php'],
        'page_files' => [],
    ],
    'planet420' => [
        'headers' => [],
        'middleware_files' => ['page/_planet420.class.php'],
        'page_files' => [],
    ],
    'exit' => [
        'headers' => [],
        'middleware_files' => [],
        'page_files' => [],
    ],
];
