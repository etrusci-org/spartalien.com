import { LazyMedia } from './lazymedia.js';
import { Scur } from './scur.js';
window.addEventListener('load', () => {
    new LazyMedia().autoembed();
    new Scur().autodeob();
    document.querySelectorAll('a').forEach(e => {
        if (e.hostname && document.location.hostname != e.hostname) {
            e.setAttribute('target', '_blank');
        }
    });
}, false);
