<?php
/*
On content change:
- adjust validRequestPatterns and run app/protected/gen-validrequests.php

Before deploy:
- set APP_PRODUCTION_MODE to true
- comment-out the files redirect in app/public/.htaccess
---------------------------------------------- */

define('APP_MODE_PRODUCTION', false);

error_reporting(E_ALL | E_STRICT);

$conf = array(
    // Mandatory WebApp vars:
    'dbFile' => __DIR__.'/db/main.sqlite3',
    'pageDir' => __DIR__.'/page',
    'cacheDir' => __DIR__.'/cache',
    'cachingEnabled' => false,
    'cacheTTL' => 10,
    'cacheExcludedNodes' => array(),
    'rewriteURL' => true,

    // Custom vars:
    'baseURL' => '//localhost/spartalien.com/app/public/',
    'siteTitle' => 'SPARTALIEN',
    'timezone' => 'UTC',
    'locale' => 'en-US',
    'encoding' => 'UTF-8',
    'nav' => array(
        array('news', 'NEWS'),
        array('music', 'MUSIC'),
        array('visual', 'VISUAL'),
        array('stuff', 'STUFF'),
        array('planet420', '420'),
        array('about', 'ABOUT'),
        // to add or ditch completely: merch, prod, cam, links
    ),
    'validateRequests' => true,
    'validRequestPatterns' => array( # after updating these patterns, run app/protected/gen-validrequests.php once to generate app/protected/cache/valid-requests.php which is required in app/protected/init.php
        '',
        'index',
        'news',
        'news/id:[1-53]',
        'music',
        'music/freedl',
        'music/id:[1-33]',
        'music/type:[album|ep|remix|single]',
        'music/year:[2016-2021]',
        'visual',
        'visual/id:[1-40]',
        'stuff',
        'stuff/id:[1-14]',
        'planet420',
        'planet420/artists',
        'planet420/session/num:[1-38]',
        'about',
    ),
);


if (APP_MODE_PRODUCTION) {
    error_reporting(0);
    $conf['cachingEnabled'] = true;
    $conf['cacheTTL'] = 31_536_000;
    $conf['baseURL'] = '//spartalien.com/';
}
