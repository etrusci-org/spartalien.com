<?php
preg_match('/music\/id\:\[\d\-(\d+)\]/', $this->conf['validRequestPatterns'][2], $match);
$latestAudioReleaseID = $match[1];
?>


<div class="grid two text-align-center">
    <div>
        <p>LATEST MUSIC RELEASE</p>
        <p>
            <a href="<?php print($this->routeURL('music/id:%s', [$latestAudioReleaseID])); ?>">
                <img src="file/cover/<?php print($latestAudioReleaseID); ?>-med.jpg" alt="cover art">
            </a>
        </p>
    </div>

    <div>
        <p>JOIN INSIDER CLUB</p>
        <a href="http://eepurl.com/dqYlHr">
            <img src="res/newsletter-qr.png" alt="qrcode">
        </a>
    </div>

    <div>
        <p>ELSEWHERE</p>
        <p>
            <?php $this->printElsewhereButtons(); ?>
        </p>
    </div>

    <div>
        <p>RANDOM QUOTE <small>(<a href="#" class="random-quote-reload">reload</a>)</small></p>
        <noscript><div class="noscript">JavaScript required</div></noscript>
        <div class="random-quote-target"></div>
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

    setInterval(() => {
        RandomQuoteTyper.typeQuote()
    }, 600_000)

    randomQuoteReload.addEventListener('click', (event) => {
        event.preventDefault()
        RandomQuoteTyper.typeQuote()
    }, false)
</script>
