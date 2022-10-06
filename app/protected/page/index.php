<?php
$trackList = [];

$releaseList = $this->getAudio('releaseList');
foreach ($releaseList as $k => $v) {
    $trackList = array_merge($trackList, array_map(function(array $t) use ($v): array {
        $t = [
            'audioID' => $t['id'],
            'audioName' => $t['audioName'],
            'bandcampID' => $t['bandcampID'],
            'releaseType' => $v['releaseType'],
            'releaseName' => $v['releaseName'],
            'releaseRoute' => $this->routeURL('music/id:%1$s', [$v['id']]),
        ];
        return $t;
    }, $this->getAudioByID($v['audioIDs'])));
}

$trackList = jsonEncode($trackList, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>




<div class="text-align-center">
    <div class="random-audio"></div>
</div>





<script>
    const trackList = <?php print($trackList.PHP_EOL); ?>
</script>
