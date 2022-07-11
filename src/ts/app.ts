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
            // RandomQuoteTyper.typingSpeed = 20

            if (RandomQuoteTyper.target) {
                let noise = new Audio('res/brownian2500.mp3')
                noise.play()

                setTimeout(() => {
                    RandomQuoteTyper.typeQuote()
                }, 2_600) // audio length + 100ms

                RandomQuoteTyper.target.addEventListener('click', (event) => {
                    RandomQuoteTyper.typeQuote()
                    event.preventDefault()
                })
            }
        }
    },
}
