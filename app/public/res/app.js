import { Scur } from './vendor/scur.js';
import { LazyMedia } from './vendor/LazyMedia.js';
import { addTargetToExtLinks } from './vendor/addTargetToExtLinks.js';
export const App = {
    main() {
        console.log('SPARTALIEN.COM');
        LazyMedia.embed();
        Scur.deobElements();
        addTargetToExtLinks();
    },
};
