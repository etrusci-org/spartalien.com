export const LazyMedia = {
    selector: '.lazymedia',
    slugSuffix: {
        generic: {
            link: '',
            image: '',
            audio: '',
            video: '',
        },
        bandcamp: {
            track: '/size=large/bgcol=ffffff/linkcol=0687f5/artwork=none/transparent=true/tracklist=false/',
            album: '/size=large/bgcol=ffffff/linkcol=0687f5/artwork=none/transparent=true/',
        },
        mixcloud: {
            mix: '&hide_cover=1',
            playlist: '&hide_cover=1',
        },
        youtube: {
            video: '?modestbranding=1&rel=0',
            playlist: '&modestbranding=1&rel=0',
        },
    },
    bandcampAlbumAutoHeight: {
        header: 120,
        trackRow: 33,
        bottomBar: 50,
    },
    embed() {
        let nodes = document.querySelectorAll(this.selector);
        if (!nodes) {
            console.error('bad nodes:', nodes);
            return;
        }
        nodes.forEach(node => {
            if (node instanceof HTMLElement) {
                let code = null;
                try {
                    code = JSON.parse(node.innerHTML);
                    if (!code || !code.platform || !code.type || !code.slug) {
                        code = null;
                        throw 'invalid JSON or missing platform, type or slug';
                    }
                }
                catch (error) {
                    console.error('bad code:', node.innerHTML, 'in node:', node, 'error message:', error);
                }
                if (code) {
                    let e = null;
                    if (code.platform == 'generic') {
                        if (code.type == 'link') {
                            e = this.createDefaultElement('a', node);
                            e.setAttribute('href', `${code.slug}${this.slugSuffix.generic.link}`);
                            e.innerText = (code.text) ? code.text : code.slug;
                        }
                        if (code.type == 'image') {
                            e = this.createDefaultElement('img', node);
                            e.setAttribute('src', `${code.slug}${this.slugSuffix.generic.image}`);
                            e.setAttribute('alt', code.slug.split('/').pop() || code.slug);
                        }
                        if (code.type == 'audio') {
                            e = this.createDefaultElement('audio', node);
                            e.setAttribute('preload', 'metadata');
                            e.setAttribute('controls', 'true');
                            let e2 = this.createDefaultElement('source');
                            e2.setAttribute('src', `${code.slug}${this.slugSuffix.generic.audio}`);
                            let audioType = null;
                            let audioExt = code.slug.split('.').pop() || code.slug;
                            if (audioExt == 'mp3') {
                                audioType = 'audio/mpeg';
                            }
                            if (audioExt == 'mp4') {
                                audioType = 'audio/mp4';
                            }
                            if (audioType) {
                                e2.setAttribute('type', audioType);
                            }
                            e.appendChild(e2);
                        }
                        if (code.type == 'video') {
                            e = this.createDefaultElement('video', node);
                            e.setAttribute('preload', 'metadata');
                            e.setAttribute('controls', 'true');
                            let e2 = this.createDefaultElement('source');
                            e2.setAttribute('src', `${code.slug}${this.slugSuffix.generic.video}`);
                            let videoType = null;
                            let videoExt = code.slug.split('.').pop() || code.slug;
                            if (videoExt == 'mp4') {
                                videoType = 'video/mp4';
                            }
                            if (videoExt == 'webm') {
                                videoType = 'video/webm';
                            }
                            if (videoExt == 'ogv') {
                                videoType = 'video/ogg';
                            }
                            if (videoType) {
                                e2.setAttribute('type', videoType);
                            }
                            e.appendChild(e2);
                        }
                    }
                    if (code.platform == 'bandcamp') {
                        e = this.createDefaultElement('iframe', node);
                        if (code.type == 'track') {
                            e.setAttribute('src', `//bandcamp.com/EmbeddedPlayer/track=${code.slug}${this.slugSuffix.bandcamp.track}`);
                        }
                        if (code.type == 'album') {
                            e.setAttribute('src', `//bandcamp.com/EmbeddedPlayer/album=${code.slug}${this.slugSuffix.bandcamp.album}`);
                            if (code.trackCount) {
                                e.style.height = `${Math.round(this.bandcampAlbumAutoHeight.header + (this.bandcampAlbumAutoHeight.trackRow * code.trackCount) + this.bandcampAlbumAutoHeight.bottomBar)}px`;
                            }
                        }
                    }
                    if (code.platform == 'mixcloud') {
                        e = this.createDefaultElement('iframe', node);
                        if (code.type == 'mix') {
                            e.setAttribute('src', `//www.mixcloud.com/widget/iframe/?feed=${code.slug}${this.slugSuffix.mixcloud.mix}`);
                        }
                        if (code.type == 'playlist') {
                            e.setAttribute('src', `//www.mixcloud.com/widget/iframe/?feed=${code.slug}${this.slugSuffix.mixcloud.playlist}`);
                        }
                    }
                    if (code.platform == 'youtube') {
                        e = this.createDefaultElement('iframe', node);
                        e.setAttribute('allowfullscreen', 'true');
                        if (code.type == 'video') {
                            if (code.timeStart) {
                                this.slugSuffix.youtube.video = `${this.slugSuffix.youtube.video}&t=${code.timeStart}`;
                            }
                            e.setAttribute('src', `//www.youtube.com/embed/${code.slug}${this.slugSuffix.youtube.video}`);
                        }
                        if (code.type == 'playlist') {
                            e.setAttribute('src', `//www.youtube.com/embed/videoseries?list=${code.slug}${this.slugSuffix.youtube.playlist}`);
                        }
                    }
                    if (e) {
                        e.classList.add(code.platform, code.type);
                        if (code.label) {
                            let nodeLabel = this.createDefaultElement('label');
                            nodeLabel.innerText = code.label;
                            node.insertAdjacentElement('beforebegin', nodeLabel);
                        }
                        else {
                            if (code.platform == 'generic' && code.type == 'audio') {
                                let nodeLabel = this.createDefaultElement('label');
                                nodeLabel.innerText = code.slug.split('/').pop() || code.slug;
                                node.insertAdjacentElement('beforebegin', nodeLabel);
                            }
                        }
                        if (code.attribute) {
                            for (const [k, v] of code.attribute) {
                                if (v != 'false') {
                                    e.setAttribute(k, v);
                                }
                                else {
                                    e.removeAttribute(k);
                                }
                            }
                        }
                        if (code.dataset) {
                            for (const [k, v] of code.dataset) {
                                e.dataset[k] = v;
                            }
                        }
                        console.debug('[lazymedia]', 'code:', node.innerHTML, 'baked element:', e);
                        node.replaceWith(e);
                    }
                }
            }
        });
    },
    createDefaultElement(tag, targetNode) {
        let e = document.createElement(tag);
        if (tag == 'iframe' || tag == 'img') {
            e.setAttribute('loading', 'lazy');
        }
        if (targetNode) {
            e.classList.add('lazymedia', ...targetNode.classList);
            let style = targetNode.getAttribute('style');
            if (style) {
                e.setAttribute('style', style);
            }
        }
        return e;
    },
};
