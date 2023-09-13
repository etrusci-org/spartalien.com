import { LazyMedia } from './lazymedia.js';
import { Scur } from './scur.js';
import { ImgZoom } from './imgzoom.js';
import { ElFilter } from './elfilter.js';
import { scroll_to_top, add_anchor_target_to_external_links } from './nifty.js';
window.addEventListener('load', () => {
    new LazyMedia().autoembed();
    new Scur().autodeob();
    new ImgZoom();
    new ElFilter();
    add_anchor_target_to_external_links();
    const stt_ele = document.querySelector('a.scroll_to_top');
    if (stt_ele) {
        stt_ele.addEventListener('click', (event) => {
            event.preventDefault();
            scroll_to_top();
        }, false);
    }
}, false);
