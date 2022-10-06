<?php
declare(strict_types=1);


$cacheFile = sprintf('%s/version.json', $conf['cacheDir']);

if (file_exists($cacheFile)) {
    $version = jsonDecode(file_get_contents($cacheFile));
}
else {
    $version = [
        'favicon' => filemtime('favicon.ico'),
        'og' => filemtime('res/og.jpg'),
        'css' => filemtime('res/style.min.css'),
        'js' => array_sum(
            array_map(function(string $v): int {
                return filemtime($v);
            }, array_merge(
                glob('res/*.js'),
                glob('res/vendor/*.js'),
            ))
        ),
    ];
    file_put_contents($cacheFile, jsonEncode($version));
}

define('VERSION', $version);
