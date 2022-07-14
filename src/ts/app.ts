import { LazyMedia } from './vendor/LazyMedia.js'
import { Scur } from './vendor/scur.js'
import { addTargetToExtLinks } from './vendor/addTargetToExtLinks.js'
import { ImagePreview } from './ImagePreview.js'
import { RandomQuoteTyper } from './RandomQuoteTyper.js'


export const App: AppInterface = {
    main(routeRequest = '') {
        console.log(`SPARTALIEN.COM${(routeRequest) ? ` :: ${routeRequest}` : ``}`)

        // LazyMedia.debug = true
        LazyMedia.embed()

        Scur.deobElements()

        addTargetToExtLinks()

        ImagePreview.init()

        if (routeRequest == '') {
            RandomQuoteTyper.init()
            if (RandomQuoteTyper.target) {
                RandomQuoteTyper.target.addEventListener('click', (event) => {
                    RandomQuoteTyper.typeQuote()
                    event.preventDefault()
                })

                let noise = new Audio('res/brownian2500.mp3')
                noise.play()
                noise.volume = 1
                noise.autoplay = true
                noise.preload = 'auto'

                setTimeout(() => {
                    noise.volume = 0
                    RandomQuoteTyper.typeQuote()
                }, 2_000)
            }
        }
    },
}
