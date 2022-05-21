<?php
require __DIR__.'/../conf.php';

$dump = glob(sprintf('%s/*.php', $conf['cacheDir']));

foreach ($dump as $f) {
    if ((time() - filemtime($f)) > $conf['cacheTTL']) {
        // print("deleting $f\n");
        unlink($f);
    }
}
