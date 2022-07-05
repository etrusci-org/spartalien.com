import { LazyMedia } from './vendor/LazyMedia.js';
import { Scur } from './vendor/scur.js';
import { addTargetToExtLinks } from './vendor/addTargetToExtLinks.js';
import { ImagePreview } from './ImagePreview.js';
export const App = {
    main() {
        console.log('SPARTALIEN.COM');
        LazyMedia.slugTpl.bandcampAlbum = LazyMedia.slugTpl.bandcampAlbum.replace('tracklist=true', 'tracklist=false');
        LazyMedia.embed();
        Scur.deobElements();
        addTargetToExtLinks();
        ImagePreview.init();
    },
};
