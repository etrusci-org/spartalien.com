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
        array('', 'Index'),
        array('news', 'News'),
        array('music', 'Music'),
        // array('visual', 'Visual'),
        // array('merch', 'Merch'),
        array('cam', 'Cam'),
        array('planet420', 'Planet420'),
        array('about', 'About'),
    ),
);
