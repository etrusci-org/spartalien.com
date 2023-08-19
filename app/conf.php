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
    'home' => [
        'link' => '.',
        'link_text' => 'Home',
    ],
    'music' => [
        'link' => './music',
        'link_text' => 'Music Releases',
    ],
    'musicvideo' => [
        'link' => './musicvideo',
        'link_text' => 'Music Videos',
    ],
    'catalog' => [
        'link' => './catalog',
        'link_text' => 'Tracks Catalog',
    ],
    'visual' => [
        'link' => './visual',
        'link_text' => 'Visuals',
    ],
    'physical' => [
        'link' => './physical',
        'link_text' => 'Physical Things',
    ],
    'planet420' => [
        'link' => './planet420',
        'link_text' => 'Planet 420 Mixtapes',
    ],
    'mixtape' => [
        'link' => './mixtape',
        'link_text' => 'Other Mixtapes',
    ],
    'tool' => [
        'link' => './tool',
        'link_text' => 'Creative Tools',
    ],
    'stuff' => [
        'link' => './stuff',
        'link_text' => 'Stuff',
    ],
    'mention' => [
        'link' => './mention',
        'link_text' => 'Mentions',
    ],
    'news' => [
        'link' => './news',
        'link_text' => 'News',
    ],
    'about' => [
        'link' => './about',
        'link_text' => 'About',
    ],
    'exit' => [
        'link' => './exit',
        'link_text' => 'Exit',
    ],
    '404test' => [
        'link' => './no-existing-page',
        'link_text' => '404test',
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
