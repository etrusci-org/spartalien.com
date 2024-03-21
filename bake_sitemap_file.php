#!/usr/bin/env php
<?php
declare(strict_types=1);
namespace s9com;


$APP_DIR = realpath(__DIR__.'/app');


require $APP_DIR.'/conf.php';

/*
<?xml version="1.0" encoding="utf-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>https://spartalien.com/NODE</loc></url>
    ...
</urlset>
*/


$dump = '';

foreach ($conf['site_nav'] as $v) {
    $dump .= sprintf('<url><loc>https://spartalien.com/%s</loc></url>', ltrim($v['link'], './'));
}


$dump = '<?xml version="1.0" encoding="utf-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
'.$dump.'
<url><loc>https://spartalien.com/privacy</loc></url>
<url><loc>https://spartalien.com/purchase</loc></url>
</urlset>';

file_put_contents($conf['sitemap_file'], $dump, LOCK_EX);

print(microtime(true).' baked sitemap ('.filesize($conf['sitemap_file']).' bytes)'.PHP_EOL);
