import { Scur } from './vendor/scur.js';
import { pathBasename } from './vendor/pathBasename.js';
export const App = {
    main() {
        console.log('SPARTALIEN.COM');
        this.loadLazyMedia();
        Scur.deobElements();
    },
    loadLazyMedia() {
        let nodeList = document.querySelectorAll('[data-lazymedia]');
        if (nodeList instanceof NodeList) {
            nodeList.forEach(node => {
                if (node instanceof HTMLElement &&
                    node.dataset['lazymedia'] !== undefined) {
                    let mediaCode = node.dataset['lazymedia'].split(':');
                    let platform = mediaCode.slice(0, 1).join('');
                    let type = mediaCode.slice(1, 2).join('');
                    let slug = mediaCode.slice(2).join(':');
                    if (platform == 'youtube') {
                        let embedEle = document.createElement('iframe');
                        embedEle.classList.add('lazymedia');
                        embedEle.setAttribute('loading', 'lazy');
                        if (type == 'video') {
                            embedEle.setAttribute('src', `//www.youtube.com/embed/${slug}?modestbranding=1&color=white&rel=0`);
                            embedEle.setAttribute('allowfullscreen', 'true');
                            node.replaceWith(embedEle);
                        }
                        if (type == 'playlist') {
                            embedEle.setAttribute('src', `//www.youtube.com/embed/videoseries?list=${slug}&modestbranding=1&color=white&rel=0`);
                            embedEle.setAttribute('allowfullscreen', 'true');
                            node.replaceWith(embedEle);
                        }
                    }
                    if (platform == 'bandcamp') {
                        let embedEle = document.createElement('iframe');
                        embedEle.classList.add('lazymedia');
                        embedEle.setAttribute('loading', 'lazy');
                        if (type == 'track') {
                            embedEle.setAttribute('src', `//bandcamp.com/EmbeddedPlayer/track=${slug}/size=small/bgcol=ffffff/linkcol=0687f5/artwork=none/transparent=true/`);
                            embedEle.classList.add('bandcamp', 'track');
                            node.replaceWith(embedEle);
                        }
                        if (type == 'album') {
                            embedEle.setAttribute('src', `//bandcamp.com/EmbeddedPlayer/album=${slug}/size=large/bgcol=ffffff/linkcol=0687f5/artwork=none/transparent=true/`);
                            embedEle.classList.add('bandcamp', 'album');
                            node.replaceWith(embedEle);
                        }
                    }
                    if (platform == 'mixcloud') {
                        let embedEle = document.createElement('iframe');
                        embedEle.classList.add('lazymedia');
                        embedEle.setAttribute('loading', 'lazy');
                        if (type == 'mix') {
                            embedEle.setAttribute('src', `//www.mixcloud.com/widget/iframe/?hide_cover=1&feed=${slug}`);
                            embedEle.classList.add('mixcloud', 'mix');
                            node.replaceWith(embedEle);
                        }
                        if (type == 'playlist') {
                            embedEle.setAttribute('src', `//www.mixcloud.com/widget/iframe/?hide_cover=1&feed=${slug}`);
                            embedEle.classList.add('mixcloud', 'playlist');
                            node.replaceWith(embedEle);
                        }
                    }
                    if (platform == 'generic') {
                        if (slug.slice(0, 4) != 'http') {
                            slug = `file/${slug}`;
                        }
                        if (type == 'none') {
                            let embedEle = document.createElement('a');
                            embedEle.classList.add('lazymedia');
                            embedEle.setAttribute('href', slug);
                            embedEle.innerHTML = pathBasename(slug);
                            node.replaceWith(embedEle);
                        }
                        if (type == 'image') {
                            let embedEle = document.createElement('img');
                            embedEle.classList.add('lazymedia');
                            embedEle.setAttribute('src', slug);
                            embedEle.setAttribute('alt', slug);
                            embedEle.setAttribute('loading', 'lazy');
                            node.replaceWith(embedEle);
                        }
                        if (type == 'video') {
                            let embedEle1 = document.createElement('video');
                            embedEle1.classList.add('lazymedia');
                            embedEle1.setAttribute('autoplay', 'true');
                            embedEle1.setAttribute('loop', 'true');
                            embedEle1.setAttribute('controls', 'true');
                            let embedEle2 = document.createElement('source');
                            embedEle2.setAttribute('src', slug);
                            embedEle2.setAttribute('type', 'video/mp4');
                            embedEle1.appendChild(embedEle2);
                            node.replaceWith(embedEle1);
                        }
                    }
                }
            });
        }
    },
};
