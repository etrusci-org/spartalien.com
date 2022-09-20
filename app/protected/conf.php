<?php
define('APP_MODE_PRODUCTION', false);

error_reporting(E_ALL);

$conf = array(
    // Mandatory WebApp vars:
    'dbFile' => __DIR__.'/db/main.sqlite3',
    'pageDir' => __DIR__.'/page',
    'cacheDir' => __DIR__.'/cache',
    'cachingEnabled' => false,
    'cacheTTL' => 60,
    'cacheExcludedNodes' => array('search'),
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
    'validRequestPatterns' => array(
        '', // index
        'music',
        'music/id:[1-33]',
        'music/type:[album|ep|remix|single]',
        'music/year:[2016-2021]',
        'music/collab',
        'music/freedl',
        'visual',
        'visual/id:[1-41]',
        'djmixes',
        'stuff',
        'stuff/id:[1-28]',
        'planet420',
        'planet420/session/num:[1-41]',
        'planet420/artists',
        'cam',
        'news',
        'news/id:[1-61]',
        'news.atom',
        'about',
        'exit',
        'search',
        'privacy',
        'api/get:audio/id:[1-141]',
        'api/get:visual/id:[1-41]',
    ),

    'preRenderSettings' => array(
        'index' => array(
            'openDB' => 'r',
        ),
        'music' => array(
            'openDB' => 'r',
        ),
        'visual' => array(
            'openDB' => 'r',
        ),
        'stuff' => array(
            'openDB' => 'r',
        ),
        'exit' => array(
            'openDB' => 'r',
        ),
        'planet420' => array(
            'openDB' => 'r',
        ),
        'news' => array(
            'openDB' => 'r',
        ),
        'news.atom' => array(
            'headers' => array('Content-Type: application/atom+xml; charset=utf-8'),
            'openDB' => 'r',
        ),
        'search' => array(
            'openDB' => 'r',
        ),
        'api' => array(
            'headers' => array('Content-Type: application/json; charset=utf-8'),
            'openDB' => 'r',
        ),
    ),

    'elsewhere' => array(
        'newsletter' => ['Newsletter', '//eepurl.com/dqYlHr'],
        'bandcamp' => ['Bandcamp', '//spartalien.bandcamp.com'],
        'spotify' => ['Spotify', '//open.spotify.com/artist/553FKlcVkf1YFU6dl129Ef'],
        'youtube' => ['YouTube', '//youtube.com/channel/UCXwYExlRqK_oeUocuKkhRUw'],
        'mixcloud' => ['Mixcloud', '//mixcloud.com/lowtechman'],
        'discogs' => ['Discogs', '//discogs.com/artist/5977226'],
        'twitch' => ['Twitch', '//twitch.tv/spartalien'],
        'discord' => ['Discord', '//spartalien.com/discord'],
        'twitter' => ['Twitter', '//twitter.com/spartalien'],
        'instagram' => ['Instagram', '//instagram.com/spartalien'],
    ),
);


// for app/protected/bin/2-gen-cache.php:
$conf['cachePrimingURL'] = $conf['baseURL'];

// for meta tags:
$conf = array_merge($conf, array(
    'metaApplicationName' => $conf['siteTitle'],
    'metaAuthor' => 'SPARTALIEN',
    'metaGenerator' => 'Brain',
    'metaDescription' => 'SPARTALIEN\'s Website',
    'metaKeywords' => 'SPARTALIEN, arT2, lowtechman, multimedia, digital, art, music, audio, video, soundtrack, visual, code, experimental, original',
));

// for opengraph tags:
$conf = array_merge($conf, array(
    'ogTitle' => $conf['siteTitle'],
    'ogDescription' => $conf['metaDescription'],
    'ogType' => 'website',
));




if (APP_MODE_PRODUCTION) {
    error_reporting(0);
    $conf['baseURL'] = 'https://spartalien.com/';
    $conf['cachingEnabled'] = true;
    $conf['cacheTTL'] = 31_536_000_000;
}
