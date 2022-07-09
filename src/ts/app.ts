import { LazyMedia } from './vendor/LazyMedia.js'
import { Scur } from './vendor/scur.js'
import { addTargetToExtLinks } from './vendor/addTargetToExtLinks.js'
import { ImagePreview } from './ImagePreview.js'
import { RandomQuoteTyper } from './RandomQuoteTyper.js'


export const App: AppInterface = {
    main() {
        console.log('SPARTALIEN.COM')

        // LazyMedia.debug = true
        LazyMedia.embed()

        Scur.deobElements()

        addTargetToExtLinks()

        ImagePreview.init()

        // RandomQuoteTyper.typingSpeed = 20

        setTimeout(() => {
            RandomQuoteTyper.typeQuote()
        }, 2_500)

        if (RandomQuoteTyper.target) {
            RandomQuoteTyper.target.addEventListener('click', (event) => {
                RandomQuoteTyper.typeQuote()
                event.preventDefault()
            })
        }
    },
}
