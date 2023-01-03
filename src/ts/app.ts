import { LazyMedia } from './vendor/LazyMedia.js'
import { Scur } from './vendor/Scur.js'
import { addTargetToExtLinks } from './vendor/addTargetToExtLinks.js'
import { ImagePreview } from './ImagePreview.js'


export const App: AppInterface = {
    main(routeRequest = '') {
        console.log(`SPARTALIEN.COM${(routeRequest) ? ` :: ${routeRequest}` : ``}`)
        LazyMedia.embed()
        Scur.deobElements()
        ImagePreview.init()
        addTargetToExtLinks()
    },
}
