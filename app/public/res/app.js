import { LazyMedia } from './vendor/LazyMedia.js';
import { Scur } from './vendor/scur.js';
import { addTargetToExtLinks } from './vendor/addTargetToExtLinks.js';
import { ImagePreview } from './ImagePreview.js';
import { RandomQuoteTyper } from './RandomQuoteTyper.js';
export const App = {
    main(routeRequest = '') {
        console.log(`SPARTALIEN.COM${(routeRequest) ? ` :: ${routeRequest}` : ``}`);
        LazyMedia.embed();
        Scur.deobElements();
        addTargetToExtLinks();
        ImagePreview.init();
        if (routeRequest == '') {
            RandomQuoteTyper.init();
            if (RandomQuoteTyper.target) {
                RandomQuoteTyper.target.addEventListener('click', (event) => {
                    RandomQuoteTyper.typeQuote();
                    event.preventDefault();
                });
                setTimeout(() => {
                    RandomQuoteTyper.typeQuote();
                }, 2000);
            }
        }
    },
};
