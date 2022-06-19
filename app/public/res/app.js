import { Scur } from './vendor/scur.js';
import { LazyMedia } from './vendor/LazyMedia.js';
export const App = {
    main() {
        console.log('SPARTALIEN.COM');
        Scur.deobElements();
        LazyMedia.embed();
    },
};
