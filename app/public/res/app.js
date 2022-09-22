import { LazyMedia } from './vendor/LazyMedia.js';
import { Scur } from './vendor/Scur.js';
import { addTargetToExtLinks } from './vendor/addTargetToExtLinks.js';
import { ImagePreview } from './ImagePreview.js';
import { RandomQuoteTyper } from './RandomQuoteTyper.js';
export const App = {
    main(routeRequest = '') {
        console.log(`SPARTALIEN.COM${(routeRequest) ? ` :: ${routeRequest}` : ``}`);
        if (routeRequest == '') {
            if (trackList) {
                setTimeout(() => {
                    let randomAudioTarget = document.querySelector('.random-audio') || null;
                    this.loadRandomTrack(randomAudioTarget);
                }, 3000);
            }
            setTimeout(() => {
                this.loadRandomQuote();
            }, 15000);
        }
        LazyMedia.embed();
        Scur.deobElements();
        ImagePreview.init();
        addTargetToExtLinks();
    },
    loadRandomTrack(target) {
        if (!target || !trackList)
            return;
        let randomTrack = trackList[Math.floor(Math.random() * trackList.length)];
        if (!randomTrack)
            return;
        target.innerHTML = `<p><em>Not sure where to start?</em></p>`;
        setTimeout(() => {
            target.innerHTML += `
            <p><em>Here's a random track:</em></p>
            <h2><a href="${randomTrack.releaseRoute}">${randomTrack.audioName}</a></h2>
            <p>
                from the ${randomTrack.releaseType}
                <a href="${randomTrack.releaseRoute}">${randomTrack.releaseName}</a>
            </p>
            [embed goes here]<!--<iframe class="lazymedia bandcampTrack small" src="https://bandcamp.com/EmbeddedPlayer/track=${randomTrack.bandcampID}/size=small/bgcol=2b2b2b/linkcol=cccccc/artwork=true/transparent=true/"></iframe>-->
            `;
        }, 2500);
    },
    loadRandomQuote() {
        if (!quotes)
            return;
        RandomQuoteTyper.targetSelector = '.random-quote';
        RandomQuoteTyper.typingSpeed = 60;
        RandomQuoteTyper.init();
        if (!RandomQuoteTyper.target)
            return;
        RandomQuoteTyper.target.addEventListener('click', (event) => {
            RandomQuoteTyper.typeQuote();
            event.preventDefault();
        }, false);
        RandomQuoteTyper.typeQuote();
    },
};
