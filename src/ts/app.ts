import { LazyMedia } from './vendor/LazyMedia.js'
import { Scur } from './vendor/Scur.js'
import { addTargetToExtLinks } from './vendor/addTargetToExtLinks.js'
import { ImagePreview } from './ImagePreview.js'


export const App: AppInterface = {
    main(routeRequest = '') {
        console.log(`SPARTALIEN.COM${(routeRequest) ? ` :: ${routeRequest}` : ``}`)

        // index page
        if (routeRequest == '') {
            // @ts-ignore: trackList is defined in app/protected/page/index.php
            if (trackList) {
                let randomAudioTarget: HTMLDivElement|null = document.querySelector('.random-audio') || null

                setTimeout(() => {
                    this.loadRandomTrack(randomAudioTarget)
                }, 3_000)
            }
        }

        LazyMedia.embed()
        Scur.deobElements()
        ImagePreview.init()
        addTargetToExtLinks()
    },

    loadRandomTrack(target) {
        // @ts-ignore: trackList is defined in app/protected/page/index.php
        if (!target || !trackList) return
        // @ts-ignore
        let randomTrack = trackList[Math.floor(Math.random() * trackList.length)]

        if (!randomTrack) return

        target.innerHTML = `<p><em>Not sure where to start?</em></p>`

        setTimeout(() => {
            target.innerHTML += `
            <p><em>Here's a random track:</em></p>
            <h2><a href="${randomTrack.releaseRoute}">${randomTrack.audioName}</a></h2>
            <p>
                from the ${randomTrack.releaseType}
                <a href="${randomTrack.releaseRoute}">${randomTrack.releaseName}</a>
            </p>
            <iframe class="lazymedia bandcampTrack small" src="https://bandcamp.com/EmbeddedPlayer/track=${randomTrack.bandcampID}/size=small/bgcol=2b2b2b/linkcol=cccccc/artwork=true/transparent=true/"></iframe>
            `
        }, 3_000)
    }
}
