<?php
error_reporting(E_ALL | E_STRICT);

$conf = array(
    // Mandatory WebApp vars:
    'dbFile' => __DIR__.'/db/main.sqlite3',
    'pageDir' => __DIR__.'/page',
    'cacheDir' => __DIR__.'/cache',
    'cachingEnabled' => false,
    'cacheTTL' => 86400 * 365 * 1000,
    'cacheExcludedNodes' => array(),
    'rewriteURL' => true,

    // Custom vars:
    'baseURL' => '//localhost/spartalien.com/app/public/',
    'siteTitle' => 'SPARTALIEN',
    'timezone' => 'UTC',
    'locale' => 'en-US',
    'encoding' => 'UTF-8',
    'nav' => array(
        // route request, label text
        // array('', 'INDEX'),
        array('news', 'NEWS'),
        array('music', 'MUSIC'),
        array('visual', 'VISUAL'),
        // array('stuff', 'STUFF'),
        // array('merch', 'MERCH'),
        // array('cam', 'CAM'),
        array('planet420', 'PLANET 420'),
        array('about', 'ABOUT'),
    ),
    'validateRequests' => true,
    'validRequests' => array(
        '',
        'index',
        'news',
        'news/id:[1-53]',
        'music',
        'music/id:[1-33]',
        'visual',
        'visual/id:[1-40]',
        'planet420',
        'planet420/session/num:[1-38]',
        'about',
    ),
);
