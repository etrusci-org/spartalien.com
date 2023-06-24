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
    ['planet420', 'PLANET 420'],
    ['cam', 'CAM'],
    ['news', 'NEWS'],
    ['about', 'ABOUT'],
];

$conf['validateRequests'] = true;
$conf['validRequestPatterns'] = [
    '', // index
    'music',
    'music/id:[1-36]',
    'music/type:[album|ep|remix|single]',
    'music/year:[2016-2023]',
    'music/collab',
    'music/freedl',
    'visual',
    'visual/id:[1-41]',
    'djmixes',
    'stuff',
    'stuff/id:[1-31]',
    'planet420',
    'planet420/session/num:[1-45]',
    'planet420/artists',
    'cam',
    'news',
    'news/id:[1-66]',
    'news.atom',
    'about',
    'exit',
    'search',
    'privacy',
    'crates',
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
    'mixcloud' => ['Mixcloud', '//mixcloud.com/lowtechman'],
    'soundcloud' => ['SoundCloud', '//soundcloud.com/spartalien'],
    'amazon' => ['Amazon', '//music.amazon.com/search/spartalien'],
    'apple' => ['Apple', '//music.apple.com/artist/spartalien/1455263028'],
    'deezer' => ['Deezer', '//www.deezer.com/artist/50523232'],
    'resonate' => ['Resonate', '//stream.resonate.coop/artist/20951'],
    'twitch' => ['Twitch', '//twitch.tv/spartalien'],
    'youtube' => ['YouTube', '//youtube.com/@spartalien-com'],
    'odysee' => ['Odysee', '//odysee.com/@spartalien:2'],
    'discogs' => ['Discogs', '//discogs.com/artist/5977226'],
    'discord' => ['Discord', '//spartalien.com/discord'],
    'instagram' => ['Instagram', '//instagram.com/spartalien'],
    'twitter' => ['Twitter', '//twitter.com/spartalien'],
    'lastfm' => ['Last.fm', '//last.fm/user/spartalien'],
];

$conf['cachePrimingURL'] = $conf['baseURL'];

$conf['metaApplicationName'] = $conf['siteTitle'];
$conf['metaAuthor'] = 'SPARTALIEN';
$conf['metaGenerator'] = 'Brain';
$conf['metaDescription'] = 'SPARTALIEN\'s Website';
$conf['metaKeywords'] = 'SPARTALIEN, arT2, lowtechman, multimedia, digital, art, music, audio, video, soundtrack, visual, code, experimental, original';

$conf['ogDescription'] = $conf['metaDescription'];
$conf['ogType'] = 'website';

$conf['dbD6File'] = __DIR__.'/db/myd6.sqlite3';

if (APP_MODE_PRODUCTION) {
    error_reporting(0);
    $conf['baseURL'] = 'https://spartalien.com/';
    $conf['cachingEnabled'] = true;
    $conf['cacheTTL'] = 31_536_000_000;
}
