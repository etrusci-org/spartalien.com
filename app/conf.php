<?php
declare(strict_types=1);
namespace s9com;


$conf = [];

// ----------------------------------------------------------------------------

$conf['error_reporting_level'] = E_ALL;

// ----------------------------------------------------------------------------

$conf['site_title'] = 'SPARTALIEN';
$conf['site_url_scheme'] = 'http';
$conf['site_domain'] = 'localhost';
$conf['site_dir']    = '/spartalien.com/app/public/';
$conf['site_url']    = $conf['site_url_scheme'].'://'.$conf['site_domain'].$conf['site_dir'];
$conf['site_timezone'] = 'Europe/Zurich';
$conf['site_nav'] = [
    [
        'link' => '.',
        'link_text' => 'Home',
        'base_node' => 'home',
    ],
    [
        'link' => './music',
        'link_text' => 'Music Releases',
        'base_node' => 'music',
    ],
    [
        'link' => './musicvideo',
        'link_text' => 'Music Videos',
        'base_node' => 'musicvideo',
    ],
    [
        'link' => './catalog',
        'link_text' => 'Tracks Catalog',
        'base_node' => 'catalog',
    ],
    [
        'link' => './visual',
        'link_text' => 'Visuals',
        'base_node' => 'visual',
    ],
    [
        'link' => './physical',
        'link_text' => 'Physical Things',
        'base_node' => 'physical',
    ],
    [
        'link' => './planet420',
        'link_text' => 'Planet 420 Mixtapes',
        'base_node' => 'planet420',
    ],
    [
        'link' => './mixtape',
        'link_text' => 'Other Mixtapes',
        'base_node' => 'mixtape',
    ],
    [
        'link' => './tool',
        'link_text' => 'Creative Tools',
        'base_node' => 'tool',
    ],
    [
        'link' => './stuff',
        'link_text' => 'Stuff',
        'base_node' => 'stuff',
    ],
    [
        'link' => './mention',
        'link_text' => 'Mentions',
        'base_node' => 'mention',
    ],
    [
        'link' => './news',
        'link_text' => 'News',
        'base_node' => 'news',
    ],
    [
        'link' => './about',
        'link_text' => 'About',
        'base_node' => 'about',
    ],
    [
        'link' => './exit',
        'link_text' => 'Exit',
        'base_node' => 'exit',
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
        'route' => '/^catalog\/id:{val1}$/',
        'valuesTable' => 'track',
        'valuesCol' => [
            'val1' => 'id',
        ],
    ],
    [
        'route' => '/^artist\/id:{val1}$/',
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
        'route' => '/^musicvideo$/',
        'valuesTable' => '',
        'valuesCol' => [],
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
        'route' => '/^news\/id:{val1}$/',
        'valuesTable' => 'news',
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
        'class_file' => '',
        'headers' => [],
        'page_files' => [],
    ],
    'home' => [
        'class_file' => '',
        'headers' => [],
        'page_files' => [],
    ],
    'about' => [
        'class_file' => '',
        'headers' => [],
        'page_files' => [],
    ],
    'catalog' => [
        'class_file' => 'music',
        'headers' => [],
        'page_files' => [],
    ],
    'artist' => [
        'class_file' => 'music',
        'headers' => [],
        'page_files' => [],
    ],
    'music' => [
        'class_file' => 'music',
        'headers' => [],
        'page_files' => [],
    ],
    'musicvideo' => [
        'class_file' => '',
        'headers' => [],
        'page_files' => [],
    ],
    'physical' => [
        'class_file' => 'physical',
        'headers' => [],
        'page_files' => [],
    ],
    'visual' => [
        'class_file' => 'visual',
        'headers' => [],
        'page_files' => [],
    ],
    'tool' => [
        'class_file' => '',
        'headers' => [],
        'page_files' => [],
    ],
    'stuff' => [
        'class_file' => 'stuff',
        'headers' => [],
        'page_files' => [],
    ],
    'mixtape' => [
        'class_file' => '',
        'headers' => [],
        'page_files' => [],
    ],
    'news' => [
        'class_file' => 'news',
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
    'mention' => [
        'class_file' => 'mention',
        'headers' => [],
        'page_files' => [],
    ],
    'planet420' => [
        'class_file' => 'p420',
        'headers' => [],
        'page_files' => [],
    ],
    'exit' => [
        'class_file' => '',
        'headers' => [],
        'page_files' => [],
    ],
];

// // ----------------------------------------------------------------------------
// // Template stuff

// $conf['default_css_file'] = './res/style.min.css';
