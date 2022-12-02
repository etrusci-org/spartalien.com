<?php
define('APP_MODE_PRODUCTION', false);

error_reporting(E_ALL);

// Mandatory WebApp vars:
$conf = [
    'dbFile' => __DIR__.'/db/main.sqlite3',
    'pageDir' => __DIR__.'/page',
    'cacheDir' => __DIR__.'/cache',
    'cachingEnabled' => false,
    'cacheTTL' => 60,
    'cacheExcludedNodes' => ['search'],
    'rewriteURL' => true,
];

// Custom vars:
$conf['baseURL'] = 'http://localhost/spartalien.com/app/public/';
$conf['siteTitle'] = 'SPARTALIEN';
$conf['timezone'] = 'UTC';
$conf['locale'] = 'en-US';
$conf['encoding'] = 'UTF-8';

$conf['nav'] = [
    ['music', 'MUSIC'],
    ['visual', 'VISUAL'],
    ['stuff', 'STUFF'],
    ['planet420', 'P420'],
    ['cam', 'CAM'],
    ['news', 'NEWS'],
    ['about', 'ABOUT'],
];

$conf['validateRequests'] = true;
$conf['validRequestPatterns'] = [
    '', // index
    'music',
    'music/id:[1-34]',
    'music/type:[album|ep|remix|single]',
    'music/year:[2016-2022]',
    'music/collab',
    'music/freedl',
    'visual',
    'visual/id:[1-41]',
    'djmixes',
    'stuff',
    'stuff/id:[1-30]',
    'planet420',
    'planet420/session/num:[1-41]',
    'planet420/artists',
    'cam',
    'news',
    'news/id:[1-64]',
    'news.atom',
    'about',
    'exit',
    'search',
    'privacy',
];

$conf['preRenderSettings'] = [
    'index' => [
        'openDB' => 'r',
    ],
    'music' => [
        'openDB' => 'r',
    ],
    'visual' => [
        'openDB' => 'r',
    ],
    'stuff' => [
        'openDB' => 'r',
    ],
    'exit' => [
        'openDB' => 'r',
    ],
    'planet420' => [
        'openDB' => 'r',
    ],
    'news' => [
        'openDB' => 'r',
    ],
    'news.atom' => [
        'headers' => [
            'Content-Type: application/atom+xml; charset=utf-8'
        ],
        'openDB' => 'r',
    ],
    'search' => [
        'openDB' => 'r',
    ],
];

$conf['elsewhere'] = [
    'newsletter' => ['Newsletter', '//eepurl.com/dqYlHr'],
    'bandcamp' => ['Bandcamp', '//spartalien.bandcamp.com'],
    'spotify' => ['Spotify', '//open.spotify.com/artist/553FKlcVkf1YFU6dl129Ef'],
    'resonate' => ['Resonate', '//stream.resonate.coop/artist/20951'],
    'mixcloud' => ['Mixcloud', '//mixcloud.com/lowtechman'],
    'twitch' => ['Twitch', '//twitch.tv/spartalien'],
    'odysee' => ['Odysee', '//odysee.com/@spartalien:2'],
    'youtube' => ['YouTube', '//youtube.com/@spartalien-com'],
    'discogs' => ['Discogs', '//discogs.com/artist/5977226'],
    'discord' => ['Discord', '//spartalien.com/discord'],
    'instagram' => ['Instagram', '//instagram.com/spartalien'],
    'twitter' => ['Twitter', '//twitter.com/spartalien'],
];

$conf['cachePrimingURL'] = $conf['baseURL'];

$conf['metaApplicationName'] = $conf['siteTitle'];
$conf['metaAuthor'] = 'SPARTALIEN';
$conf['metaGenerator'] = 'Brain';
$conf['metaDescription'] = 'SPARTALIEN\'s Website';
$conf['metaKeywords'] = 'SPARTALIEN, arT2, lowtechman, multimedia, digital, art, music, audio, video, soundtrack, visual, code, experimental, original';

$conf['ogTitle'] = $conf['siteTitle'];
$conf['ogDescription'] = $conf['metaDescription'];
$conf['ogType'] = 'website';

if (APP_MODE_PRODUCTION) {
    error_reporting(0);
    $conf['baseURL'] = 'https://spartalien.com/';
    $conf['cachingEnabled'] = true;
    $conf['cacheTTL'] = 31_536_000_000;
}
