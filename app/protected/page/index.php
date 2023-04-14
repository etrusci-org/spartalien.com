<?php
preg_match('/music\/id\:\[\d\-(\d+)\]/', $this->conf['validRequestPatterns'][2], $match);
$latestAudioReleaseID = $match[1];
?>


<div class="grid two text-align-center">
    <div>
        <h3>LATEST MUSIC RELEASE</h3>
        <p>
            <a href="<?php print($this->routeURL('music/id:%s', [$latestAudioReleaseID])); ?>">
                <img src="file/cover/<?php print($latestAudioReleaseID); ?>-med.jpg" alt="cover art">
            </a>
        </p>
    </div>

    <div>
        <h3>JOIN INSIDER CLUB</h3>
        <p>
            <a href="<?php print($this->conf['elsewhere']['newsletter'][1]); ?>"><img src="res/newsletter-qr.png" alt="qrcode"></a>
            </p>
    </div>

    <div>
        <h3>ELSEWHERE</h3>
        <p>
            <?php $this->printElsewhereButtons(); ?>
        </p>
    </div>

    <div>
        <h3>RANDOM QUOTE</h3>
        <noscript><div class="noscript">JavaScript required</div></noscript>
        <p class="random-quote-target"></p>
        <p><small>(<a href="#" class="random-quote-reload">reload</a>)</small></p>
    </div>
</div>


<script type="module">
    import { RandomQuoteTyper } from "./res/vendor/RandomQuoteTyper.js"
    import { quotes } from 'https://cdn.jsdelivr.net/gh/etrusci-org/quotes@main/js/quotes-s9.min.js'

    let randomQuoteReload = document.querySelector('.random-quote-reload')

    RandomQuoteTyper.targetSelector = '.random-quote-target'

    if (quotes) {
        RandomQuoteTyper.init(quotes)
        RandomQuoteTyper.typeQuote()
    }

    randomQuoteReload.addEventListener('click', (event) => {
        event.preventDefault()
        RandomQuoteTyper.typeQuote()
    }, false)
</script>
