<?php
preg_match('/music\/id\:\[\d\-(\d+)\]/', $this->conf['validRequestPatterns'][2], $match);
$latestAudioReleaseID = ($match) ? $match[1] : null;
if ($latestAudioReleaseID) {
    printf('<script>const latestAudioReleaseID = %d;</script>', $latestAudioReleaseID);
}
?>


<div class="grid two text-align-center">

    <div>
        <p>random music release... <small>(<a href="#" class="random-audio-reload">reload</a>)</small></p>
        <noscript><div class="noscript">JavaScript required</div></noscript>
        <div class="random-audio-target" style="background-image: url(res/loading.gif); background-position: 50% 50%; background-repeat: no-repeat; background-size: 1rem;"></div>
    </div>

    <div>
        <p>join insider club...</p>
        <a href="http://eepurl.com/dqYlHr">
            <img src="res/newsletter-qr.png" alt="qrcode">
        </a>
    </div>

    <div>
        <p>elsewhere...</p>
        <?php
        foreach ($this->conf['elsewhere'] as $v) {
            if (strtolower($v[0]) == 'newsletter') continue;
            printf(
                '
                <a class="btn" href="%2$s">%1$s</a>',
                $v[0],
                $v[1],
            );
        }
        ?>
    </div>

    <div>
        <p>random quote... <small>(<a href="#" class="random-quote-reload">reload</a>)</small></p>
        <noscript><div class="noscript">JavaScript required</div></noscript>
        <div class="random-quote-target"></div>
    </div>
</div>


<script type="module">
    import { RandomQuoteTyper } from "./res/vendor/RandomQuoteTyper.js"
    import { quotes } from 'https://cdn.jsdelivr.net/gh/etrusci-org/quotes@main/js/quotes-s9.min.js'

    let randomAudioReload = document.querySelector('.random-audio-reload')
    let randomQuoteReload = document.querySelector('.random-quote-reload')

    function loadRandomAudioRelease() {
        let randomAudioTarget = document.querySelector('.random-audio-target')

        if (randomAudioTarget && latestAudioReleaseID) {
            let randomAudioReleaseID = Math.floor((Math.random() * latestAudioReleaseID) + 1)

            let e1 = document.createElement('a')
            e1.setAttribute('href', `music/id:${randomAudioReleaseID}`)

            let e2 = document.createElement('img')
            e2.setAttribute('src', `file/cover/${randomAudioReleaseID}-med.jpg`)
            e2.setAttribute('alt', 'coverart')

            e1.append(e2)
            randomAudioTarget.innerHTML = ''
            randomAudioTarget.append(e1)
        }
    }

    loadRandomAudioRelease()

    randomAudioReload.addEventListener('click', (event) => {
        event.preventDefault()
        loadRandomAudioRelease()
    }, false)

    // ---------------------------------------------------------------------------------

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
