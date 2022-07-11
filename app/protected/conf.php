<?php
/*
On content change:
- adjust validRequestPatterns and run app/protected/gen-validrequests.php (run build task to do so)

Before deploy:
- set APP_PRODUCTION_MODE to true
- comment-out the files redirect in app/public/.htaccess
---------------------------------------------- */

define('APP_MODE_PRODUCTION', false);

error_reporting(E_ALL);

$conf = array(
    // Mandatory WebApp vars:
    'dbFile' => __DIR__.'/db/main.sqlite3',
    'pageDir' => __DIR__.'/page',
    'cacheDir' => __DIR__.'/cache',
    'cachingEnabled' => false,
    'cacheTTL' => 60,
    'cacheExcludedNodes' => array(),
    'rewriteURL' => true,

    // Custom vars:
    'baseURL' => 'http://localhost/spartalien.com/app/public/',
    'siteTitle' => 'SPARTALIEN',
    'timezone' => 'UTC',
    'locale' => 'en-US',
    'encoding' => 'UTF-8',
    'nav' => array(
        array('music', 'MUSIC'),
        array('visual', 'VISUAL'),
        array('stuff', 'STUFF'),
        array('planet420', 'P420'),
        array('cam', 'CAM'),
        array('news', 'NEWS'),
        array('about', 'ABOUT'),
    ),
    'validateRequests' => true,
    'validRequestPatterns' => array( # after updating these patterns, run app/protected/gen-validrequests.php once to generate app/protected/cache/valid-requests.php which is required in app/protected/init.php
        '', // index
        'music',
        'music/id:[1-33]',
        'music/type:[album|ep|remix|single]',
        'music/year:[2016-2021]',
        'music/collab',
        'music/freedl',
        'visual',
        'visual/id:[1-41]',
        'stuff',
        'stuff/id:[1-22]',
        'planet420',
        'planet420/session/num:[1-39]',
        'planet420/artists',
        'cam',
        'news',
        'news/id:[1-53]',
        'about',
        'sitemap',
        'exit',
    ),
    'elsewhere' => array(
        'newsletter' => ['Nr', 'Newsletter', '//eepurl.com/dqYlHr'],
        'bandcamp' => ['Bp', 'Bandcamp', '//spartalien.bandcamp.com'],
        'spotify' => ['Sy', 'Spotify', '//open.spotify.com/artist/553FKlcVkf1YFU6dl129Ef'],
        'youtube' => ['Ye', 'YouTube', '//youtube.com/channel/UCXwYExlRqK_oeUocuKkhRUw'],
        'mixcloud' => ['Md', 'Mixcloud', '//mixcloud.com/lowtechman'],
        'discogs' => ['Ds', 'Discogs', '//discogs.com/artist/5977226'],
        'twitch' => ['Th', 'Twitch', '//twitch.tv/spartalien'],
        'twitter' => ['Tr', 'Twitter', '//twitter.com/spartalien'],
        'instagram' => ['Im', 'Instagram', '//instagram.com/spartalien'],
    ),
);


$conf['cachePrimingURL'] = $conf['baseURL']; // for app/protected/bin/2-gen-cache.php


if (APP_MODE_PRODUCTION) {
    error_reporting(E_ALL); // TODO: turn off after closed beta has ended
    $conf['baseURL'] = 'https://spartalien.com/v8beta/';
    $conf['cachingEnabled'] = true;
    $conf['cacheTTL'] = 31_536_000_000;
}
