import { LazyMedia } from './vendor/LazyMedia.js';
import { Scur } from './vendor/Scur.js';
import { addTargetToExtLinks } from './vendor/addTargetToExtLinks.js';
import { ImagePreview } from './ImagePreview.js';
export const App = {
    main(routeRequest = '') {
        console.log(`SPARTALIEN.COM${(routeRequest) ? ` :: ${routeRequest}` : ``}`);
        if (routeRequest == '') {
            if (trackList) {
                let randomAudioTarget = document.querySelector('.random-audio') || null;
                setTimeout(() => {
                    this.loadRandomTrack(randomAudioTarget);
                }, 3000);
            }
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
        target.innerHTML = `<em>Not sure where to start?</em>`;
        setTimeout(() => {
            target.innerHTML += `
            <em>Here's a random track:</em><br>
            <br>
            <h2><a href="${randomTrack.releaseRoute}">${randomTrack.audioName}</a></h2>
            <p>
                from the ${randomTrack.releaseType}
                <a href="${randomTrack.releaseRoute}">${randomTrack.releaseName}</a>
            </p>
            <iframe class="lazymedia bandcampTrack small" src="https://bandcamp.com/EmbeddedPlayer/track=${randomTrack.bandcampID}/size=small/bgcol=2b2b2b/linkcol=cccccc/artwork=true/transparent=true/"></iframe>
            `;
        }, 3000);
    }
};
