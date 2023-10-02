export class LazyMedia {
    element_selector = '.lazycode';
    videobox_class = 'videobox';
    error_class = 'error';
    slug_template = {
        link: '{SLUG}',
        image: '{SLUG}',
        audio: '{SLUG}',
        video: '{SLUG}',
        bandcamptrack: 'https://bandcamp.com/EmbeddedPlayer/track={SLUG}/tracklist=false/size=large/bgcol=333333/linkcol=ffffff/artwork=none/transparent=true/',
        bandcampalbum: 'https://bandcamp.com/EmbeddedPlayer/album={SLUG}/tracklist=true/size=large/bgcol=333333/linkcol=ffffff/artwork=none/transparent=true/',
        spotifytrack: 'https://open.spotify.com/embed/track/{SLUG}/?theme=0',
        spotifyepisode: 'https://open.spotify.com/embed/episode/{SLUG}/?theme=0',
        spotifyalbum: 'https://open.spotify.com/embed/album/{SLUG}/?theme=0',
        spotifyplaylist: 'https://open.spotify.com/embed/playlist/{SLUG}/?theme=0',
        mixcloudshow: 'https://player-widget.mixcloud.com/widget/iframe/?feed=/{SLUG}/&hide_cover=1&hide_artwork=1',
        mixcloudplaylist: 'https://player-widget.mixcloud.com/widget/iframe/?feed=/{SLUG}/&hide_cover=1&hide_artwork=1',
        youtubevideo: 'https://youtube.com/embed/{SLUG}?modestbranding=1&color=white&rel=0&start=0',
        youtubeplaylist: 'https://youtube.com/embed/videoseries?list={SLUG}&modestbranding=1&color=white&rel=0',
        odyseevideo: 'https://odysee.com/$/embed/{SLUG}',
    };
    bandcamp_list_height = {
        header: 119,
        row: 32,
        footer: 64,
    };
    spotify_list_height = {
        header: 200,
        row: 51,
        footer: 25,
    };
    autoembed() {
        this.get_lazycode_elements().forEach(target_element => {
            try {
                const code = JSON.parse(target_element.innerHTML);
                const baked_element = this.get_baked_element(code);
                if (baked_element) {
                    target_element.replaceWith(baked_element);
                }
                else {
                    throw (`bake() returned: ${baked_element}`);
                }
            }
            catch (error) {
                console.error(`Error on ${target_element.innerHTML}\n-> ${error}`);
                target_element.classList.add(this.error_class);
            }
        });
    }
    get_lazycode_elements() {
        return document.querySelectorAll(this.element_selector);
    }
    get_baked_element(code) {
        let baked_element = null;
        if (code.type == 'link') {
            code.slug = this.slug_template.link.replace('{SLUG}', code.slug);
            baked_element = document.createElement('a');
            baked_element.setAttribute('href', code.slug);
            this.#add_code_attr(code, baked_element);
            this.#add_code_css(code, baked_element);
            if (!code.text) {
                baked_element.innerHTML = code.slug.replace(/(^\w+:|^)\/\//, '');
            }
            else {
                baked_element.innerHTML = code.text;
            }
            if (code.target) {
                baked_element.setAttribute('target', code.target);
            }
        }
        if (code.type == 'image') {
            code.slug = this.slug_template.image.replace('{SLUG}', code.slug);
            if (!code.linkto) {
                baked_element = document.createElement('img');
                baked_element.setAttribute('src', code.slug);
                baked_element.setAttribute('loading', 'lazy');
                this.#add_code_attr(code, baked_element);
                this.#add_code_css(code, baked_element);
                if (!code.alt) {
                    baked_element.setAttribute('alt', code.slug.split('/').pop() ?? code.slug);
                }
                else {
                    baked_element.setAttribute('alt', code.alt);
                }
            }
            else {
                baked_element = document.createElement('a');
                baked_element.setAttribute('href', code.linkto);
                const inner1 = document.createElement('img');
                inner1.setAttribute('src', code.slug);
                inner1.setAttribute('loading', 'lazy');
                this.#add_code_attr(code, baked_element);
                this.#add_code_css(code, baked_element);
                if (!code.alt) {
                    inner1.setAttribute('alt', code.slug.split('/').pop() ?? code.slug);
                }
                else {
                    inner1.setAttribute('alt', code.alt);
                }
                baked_element.append(inner1);
            }
        }
        if (code.type == 'audio') {
            code.slug = this.slug_template.audio.replace('{SLUG}', code.slug);
            if (!code.label) {
                baked_element = document.createElement('audio');
                baked_element.setAttribute('src', code.slug);
                baked_element.setAttribute('loading', 'lazy');
                baked_element.setAttribute('preload', 'metadata');
                baked_element.setAttribute('controls', 'controls');
                this.#add_code_attr(code, baked_element);
                this.#add_code_css(code, baked_element);
                const inner1 = document.createElement('a');
                inner1.setAttribute('href', code.slug);
                inner1.innerHTML = code.slug;
                baked_element.append(inner1);
            }
            else {
                baked_element = document.createElement('div');
                const inner1 = document.createElement('a');
                inner1.innerHTML = code.label;
                inner1.setAttribute('href', code.slug);
                baked_element.append(inner1);
                const inner2 = document.createElement('audio');
                inner2.setAttribute('src', code.slug);
                inner2.setAttribute('loading', 'lazy');
                inner2.setAttribute('preload', 'metadata');
                inner2.setAttribute('controls', 'controls');
                this.#add_code_attr(code, inner2);
                this.#add_code_css(code, inner2);
                const inner3 = document.createElement('a');
                inner3.setAttribute('href', code.slug);
                inner3.innerHTML = code.slug;
                inner2.append(inner3);
                baked_element.append(inner2);
            }
        }
        if (code.type == 'video') {
            code.slug = this.slug_template.video.replace('{SLUG}', code.slug);
            baked_element = document.createElement('div');
            baked_element.classList.add(this.videobox_class);
            const inner1 = document.createElement('video');
            inner1.setAttribute('src', code.slug);
            inner1.setAttribute('loading', 'lazy');
            inner1.setAttribute('preload', 'metadata');
            inner1.setAttribute('controls', 'controls');
            inner1.setAttribute('playsinline', 'playsinline');
            this.#add_code_attr(code, inner1);
            this.#add_code_css(code, inner1);
            const inner2 = document.createElement('a');
            inner2.setAttribute('href', code.slug);
            inner2.innerHTML = code.slug;
            inner1.append(inner2);
            baked_element.append(inner1);
        }
        if (code.type == 'bandcamptrack') {
            code.slug = this.slug_template.bandcamptrack.replace('{SLUG}', code.slug);
            baked_element = document.createElement('iframe');
            baked_element.setAttribute('src', code.slug);
            baked_element.setAttribute('loading', 'lazy');
            this.#add_code_attr(code, baked_element);
            this.#add_code_css(code, baked_element);
        }
        if (code.type == 'bandcampalbum') {
            code.slug = this.slug_template.bandcampalbum.replace('{SLUG}', code.slug);
            if (!code.trackcount) {
                code.slug = code.slug.replace('tracklist=true', 'tracklist=false');
            }
            baked_element = document.createElement('iframe');
            baked_element.setAttribute('src', code.slug);
            baked_element.setAttribute('loading', 'lazy');
            this.#add_code_attr(code, baked_element);
            this.#add_code_css(code, baked_element);
            if (code.trackcount) {
                baked_element.style.height = `${Math.round(this.bandcamp_list_height.header + (this.bandcamp_list_height.row * code.trackcount) + this.bandcamp_list_height.footer)}px`;
            }
            else {
                baked_element.classList.add('notracklist');
            }
        }
        if (code.type == 'spotifytrack') {
            code.slug = this.slug_template.spotifytrack.replace('{SLUG}', code.slug);
            if (code.usetheme) {
                code.slug = code.slug.replace('theme=0', 'theme=1');
            }
            baked_element = document.createElement('iframe');
            baked_element.setAttribute('src', code.slug);
            baked_element.setAttribute('loading', 'lazy');
            this.#add_code_attr(code, baked_element);
            this.#add_code_css(code, baked_element);
        }
        if (code.type == 'spotifyepisode') {
            code.slug = this.slug_template.spotifyepisode.replace('{SLUG}', code.slug);
            if (code.usetheme) {
                code.slug = code.slug.replace('theme=0', 'theme=1');
            }
            baked_element = document.createElement('iframe');
            baked_element.setAttribute('src', code.slug);
            baked_element.setAttribute('loading', 'lazy');
            this.#add_code_attr(code, baked_element);
            this.#add_code_css(code, baked_element);
        }
        if (code.type == 'spotifyalbum') {
            code.slug = this.slug_template.spotifyalbum.replace('{SLUG}', code.slug);
            if (code.usetheme) {
                code.slug = code.slug.replace('theme=0', 'theme=1');
            }
            baked_element = document.createElement('iframe');
            baked_element.setAttribute('src', code.slug);
            baked_element.setAttribute('loading', 'lazy');
            this.#add_code_attr(code, baked_element);
            this.#add_code_css(code, baked_element);
            if (code.trackcount) {
                baked_element.style.height = `${Math.round(this.spotify_list_height.header + (this.spotify_list_height.row * code.trackcount) + this.spotify_list_height.footer)}px`;
            }
        }
        if (code.type == 'spotifyplaylist') {
            code.slug = this.slug_template.spotifyplaylist.replace('{SLUG}', code.slug);
            if (code.usetheme) {
                code.slug = code.slug.replace('theme=0', 'theme=1');
            }
            baked_element = document.createElement('iframe');
            baked_element.setAttribute('src', code.slug);
            baked_element.setAttribute('loading', 'lazy');
            this.#add_code_attr(code, baked_element);
            this.#add_code_css(code, baked_element);
            if (code.trackcount) {
                baked_element.style.height = `${Math.round(this.spotify_list_height.header + (this.spotify_list_height.row * code.trackcount) + this.spotify_list_height.footer)}px`;
            }
        }
        if (code.type == 'mixcloudshow') {
            code.slug = this.slug_template.mixcloudshow.replace('{SLUG}', code.slug);
            baked_element = document.createElement('iframe');
            baked_element.setAttribute('src', code.slug);
            baked_element.setAttribute('loading', 'lazy');
            this.#add_code_attr(code, baked_element);
            this.#add_code_css(code, baked_element);
        }
        if (code.type == 'mixcloudplaylist') {
            code.slug = this.slug_template.mixcloudplaylist.replace('{SLUG}', code.slug);
            baked_element = document.createElement('iframe');
            baked_element.setAttribute('src', code.slug);
            baked_element.setAttribute('loading', 'lazy');
            this.#add_code_attr(code, baked_element);
            this.#add_code_css(code, baked_element);
        }
        if (code.type == 'youtubevideo') {
            code.slug = this.slug_template.youtubevideo.replace('{SLUG}', code.slug);
            if (code.start) {
                code.slug = code.slug.replace('start=0', `start=${code.start}`);
            }
            baked_element = document.createElement('div');
            baked_element.classList.add(this.videobox_class);
            const inner1 = document.createElement('iframe');
            inner1.setAttribute('src', code.slug);
            inner1.setAttribute('loading', 'lazy');
            inner1.setAttribute('allowfullscreen', 'allowfullscreen');
            inner1.setAttribute('playsinline', 'playsinline');
            this.#add_code_attr(code, inner1);
            this.#add_code_css(code, inner1);
            baked_element.append(inner1);
        }
        if (code.type == 'youtubeplaylist') {
            code.slug = this.slug_template.youtubeplaylist.replace('{SLUG}', code.slug);
            baked_element = document.createElement('div');
            baked_element.classList.add(this.videobox_class);
            const inner1 = document.createElement('iframe');
            inner1.setAttribute('src', code.slug);
            inner1.setAttribute('loading', 'lazy');
            inner1.setAttribute('allowfullscreen', 'allowfullscreen');
            inner1.setAttribute('playsinline', 'playsinline');
            this.#add_code_attr(code, inner1);
            this.#add_code_css(code, inner1);
            baked_element.append(inner1);
        }
        if (code.type == 'odyseevideo') {
            code.slug = this.slug_template.odyseevideo.replace('{SLUG}', code.slug);
            baked_element = document.createElement('div');
            baked_element.classList.add(this.videobox_class);
            const inner1 = document.createElement('iframe');
            inner1.setAttribute('src', code.slug);
            inner1.setAttribute('loading', 'lazy');
            inner1.setAttribute('allowfullscreen', 'allowfullscreen');
            inner1.setAttribute('playsinline', 'playsinline');
            this.#add_code_attr(code, inner1);
            this.#add_code_css(code, inner1);
            baked_element.append(inner1);
        }
        return baked_element;
    }
    #add_code_attr(code, baked_element) {
        if (code.attr) {
            for (const [k, v] of code.attr) {
                if (v !== null) {
                    baked_element.setAttribute(k, v);
                }
                else {
                    baked_element.removeAttribute(k);
                }
            }
        }
    }
    #add_code_css(code, baked_element) {
        baked_element.classList.add('lazymedia', code.type);
        if (code.class) {
            baked_element.classList.add(...code.class);
        }
    }
}
