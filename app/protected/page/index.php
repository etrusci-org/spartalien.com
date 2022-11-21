<div class="text-align-center">
    <h2>NEW MUSIC ON 23. NOVEMBER 2022 !</h2>
    <h3><em>OKAY, BUT CAN YOU RAP TO THIS?</em></h3>
    <p>Finally. <a href="<?php print($this->conf['elsewhere']['newsletter'][1]); ?>" title="<?php print($this->conf['elsewhere']['newsletter'][0]); ?>">Don't miss it</a>! ;-)</p>
    <p><img src="file/cover/34-med.jpg" alt="cover art"></p>
    <?php if (date('Ymd') <= '20221123'): ?>
        <div class="videobox">
            <span class="lazycode">{
                "type": "youtubeVideo",
                "slug": "MckD1G9BZ90"
            }</span>
        </div>
    <?php else: ?>
        <span class="lazycode">{
            "type": "spotifyAlbum",
            "slug": "4CXDCmlFrKxbmQjkEINHQa",
            "trackCount": "10",
            "disableTheme": true
        }</span>
    <?php endif; ?>
</div>
