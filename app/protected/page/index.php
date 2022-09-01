<?php
$q = 'SELECT bandcampID FROM audio ORDER BY RANDOM() ASC;';
$r = $this->DB->query($q);
$audio = '[]';
if ($r) {
    $audio = array_map(function(array $v): string {
        return $v['bandcampID'];
    }, $r);
    $audio = json_encode($audio);
}
?>


<div class="introSplash text-align-center">
    Welcome!
</div>


<div class="random-audio text-align-center"></div>
<script>
    const audio = <?php print($audio.PHP_EOL); ?>
    let audioTarget = document.querySelector('.random-audio')
    let bandcampID = audio[Math.floor(Math.random() * audio.length)]
    audioTarget.innerHTML = `
    <p>Not sure where to start? Here's a random track:</p>
    <iframe class="lazymedia bandcampTrack withCover" src="//bandcamp.com/EmbeddedPlayer/track=${bandcampID}/size=large/bgcol=2b2b2b/linkcol=ffffff/minimal=true/transparent=true/"></iframe>
    <a class="btn" href="<?php print($this->routeURL('music')); ?>">more music &rarr;</a>
    `
</script>
