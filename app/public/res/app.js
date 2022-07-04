import { LazyMedia } from './vendor/LazyMedia.js';
import { Scur } from './vendor/scur.js';
import { addTargetToExtLinks } from './vendor/addTargetToExtLinks.js';
import { ImagePreview } from './ImagePreview.js';
export const App = {
    main() {
        console.group('SPARTALIEN.COM');
        LazyMedia.embed();
        Scur.deobElements();
        addTargetToExtLinks();
        ImagePreview.init();
        console.groupEnd();
    },
};
