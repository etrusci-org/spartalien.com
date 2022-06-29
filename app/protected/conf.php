<?php
/*
On content change:
- adjust validRequestPatterns and run app/protected/gen-validrequests.php (run build task to do so)

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
    ),
    'validateRequests' => true,
    'validRequestPatterns' => array( # after updating these patterns, run app/protected/gen-validrequests.php once to generate app/protected/cache/valid-requests.php which is required in app/protected/init.php
        '',
        // 'index',
        'news',
        'news/id:[1-53]',
        'music',
        'music/id:[1-33]',
        'music/type:[album|ep|remix|single]',
        'music/year:[2016-2021]',
        'music/freedl',
        'visual',
        'visual/id:[1-41]',
        'stuff',
        'stuff/id:[1-22]',
        'planet420',
        'planet420/session/num:[1-39]',
        'planet420/artists',
        'about',
        'sitemap',
        'exit',
    ),
    'elsewhere' => array(
        'newsletter' => ['Newsletter', '//eepurl.com/dqYlHr'],
        'bandcamp' => ['Bandcamp', '//spartalien.bandcamp.com'],
        'spotify' => ['Spotify', '//open.spotify.com/artist/553FKlcVkf1YFU6dl129Ef'],
        'youtube' => ['YouTube', '//www.youtube.com/channel/UCXwYExlRqK_oeUocuKkhRUw'],
        'discogs' => ['Discogs', '//www.discogs.com/artist/5977226'],
        'twitch' => ['Twitch', '//twitch.tv/spartalien'],
        'twitter' => ['Twitter', '//twitter.com/spartalien'],
        'instagram' => ['Instagram', '//instagram.com/spartalien'],
    ),
);


if (APP_MODE_PRODUCTION) {
    error_reporting(0);
    $conf['cachingEnabled'] = true;
    $conf['cacheTTL'] = 31_536_000;
    $conf['baseURL'] = '//spartalien.com/';
}
