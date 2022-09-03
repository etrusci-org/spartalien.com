<?php
$trackList = array();
$cf = sprintf('%s/tracks.json', $this->conf['cacheDir']);


if ($this->conf['cachingEnabled'] && file_exists($cf)) { // no ttl needed since we just delete the cache when content changes
    $trackList = jsonDecode(file_get_contents($cf));
}
else {
    $releaseList = $this->getAudio('releaseList');
    foreach ($releaseList as $k => $v) {
        $trackList = array_merge($trackList, array_map(function(array $t) use ($v): array {
            $t = array(
                'audioID' => $t['id'],
                'audioName' => $t['audioName'],
                'bandcampID' => $t['bandcampID'],
                'releaseType' => $v['releaseType'],
                'releaseName' => $v['releaseName'],
                'releaseRoute' => $this->routeURL(sprintf('music/id:%1$s', $v['id'])),
            );
            return $t;
        }, $this->getAudioByID($v['audioIDs'])));
    }

    if ($this->conf['cachingEnabled'] && $trackList) {
        $trackList = jsonEncode($trackList, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        file_put_contents($cf, $trackList, LOCK_EX);
    }
}

$trackList = jsonEncode($trackList, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>




<div class="text-align-center">
    <div class="random-audio"></div>
</div>





<script>
    const trackList = <?php print($trackList.PHP_EOL); ?>
</script>
