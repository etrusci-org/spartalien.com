<h2>Live Streaming Stuff</h2>

<div class="box">
    <p>
        Sometimes I stream live.
        Various topics like dj sets, music creation, experiments, etc.
        There's no fixed schedule.
        Mostly on <a href="<?php print($var_elsewhere['twitch'][1]); ?>">Twitch</a>, but very rarely also on <a href="<?php print($var_elsewhere['mixcloud'][1]); ?>">Mixcloud</a>.
    </p>
</div>



<div class="box">
    <h3>Twitch</h3>

    <div class="lazycode">{
        "type": "twitchstream",
        "slug": "spartalien&parent=<?php print($this->conf['site_domain']); ?>"
    }</div>

    <div class="lazycode">{
        "type": "twitchchat",
        "slug": "spartalien/chat?parent=<?php print($this->conf['site_domain']); ?>&darkpopout"
    }</div>
</div>
