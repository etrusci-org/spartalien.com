type LazyCode = {
    // mandatory for all
    type:
        'link'
        | 'image'
        | 'audio'
        | 'video'
        | 'bandcamptrack'
        | 'bandcampalbum'
        | 'spotifytrack'
        | 'spotifyalbum'
        | 'spotifyplaylist'
        | 'mixcloudshow'
        | 'mixcloudplaylist'
        | 'youtubevideo'
        | 'youtubeplaylist'
        | 'odyseevideo'
    slug: string

    // optional for all
    class?: string[]
    attr?: [string, string | null][] // ['foo', null] will remove the attribute foo from the target element

    // optional for link
    text?: string
    target?: string

    // optional for image
    alt?: string
    linkto?: string

    // optional for audio
    label?: string

    // optional for bandcampalbum, spotifyalbum, spotifyplaylist
    trackcount?: number

    // optional for spotifytrack, spotifyalbum, spotifyplaylist
    usetheme?: boolean

    // optional for youtubevideo
    start?: number
}




export class LazyMedia
{
    element_selector: string = '.lazycode'
    videobox_class: string = 'videobox'
    error_class: string = 'error'
    slug_template = {
        link: '{SLUG}',
        image: '{SLUG}',
        audio: '{SLUG}',
        video: '{SLUG}',
        bandcamptrack: 'https://bandcamp.com/EmbeddedPlayer/track={SLUG}/tracklist=false/size=large/bgcol=333333/linkcol=ffffff/artwork=none/transparent=true/',
        bandcampalbum: 'https://bandcamp.com/EmbeddedPlayer/album={SLUG}/tracklist=true/size=large/bgcol=333333/linkcol=ffffff/artwork=none/transparent=true/',
        spotifytrack: 'https://open.spotify.com/embed/track/{SLUG}/?theme=0',
        spotifyalbum: 'https://open.spotify.com/embed/album/{SLUG}/?theme=0',
        spotifyplaylist: 'https://open.spotify.com/embed/playlist/{SLUG}/?theme=0',
        mixcloudshow: 'https://www.mixcloud.com/widget/iframe/?feed=/{SLUG}/&hide_cover=1',
        mixcloudplaylist: 'https://www.mixcloud.com/widget/iframe/?feed=/{SLUG}/&hide_cover=1',
        youtubevideo: 'https://youtube.com/embed/{SLUG}?modestbranding=1&color=white&rel=0&start=0',
        youtubeplaylist: 'https://youtube.com/embed/videoseries?list={SLUG}&modestbranding=1&color=white&rel=0',
        odyseevideo: 'https://odysee.com/$/embed/{SLUG}',
    }
    bandcamp_list_height = {
        header: 119,
        row: 32,
        footer: 64,
    }
    spotify_list_height = {
        header: 200,
        row: 51,
        footer: 25,
    }


    autoembed(): void
    {
        this.get_lazycode_elements().forEach(target_element => {
            try {
                const code: LazyCode = JSON.parse(target_element.innerHTML)
                const baked_element = this.get_baked_element(code)

                if (baked_element) {
                    target_element.replaceWith(baked_element)
                }
                else {
                    throw (`bake() returned: ${baked_element}`)
                }
            }
            catch (error) {
                console.error(`Error on ${target_element.innerHTML}\n-> ${error}`)
                target_element.classList.add(this.error_class)
            }
        })
    }


    get_lazycode_elements(): NodeListOf<HTMLElement>
    {
        return document.querySelectorAll(this.element_selector)
    }


    get_baked_element(code: LazyCode): HTMLElement | null
    {
        let baked_element: null | HTMLElement = null

        // link
        if (code.type == 'link') {
            code.slug = this.slug_template.link.replace('{SLUG}', code.slug)

            baked_element = document.createElement('a')

            baked_element.setAttribute('href', code.slug)

            this.#add_code_attr(code, baked_element)
            this.#add_code_css(code, baked_element)

            if (!code.text) {
                baked_element.innerHTML = code.slug.replace(/(^\w+:|^)\/\//, '')
            }
            else {
                baked_element.innerHTML = code.text
            }

            if (code.target) {
                baked_element.setAttribute('target', code.target)
            }
        }

        // image
        if (code.type == 'image') {
            code.slug = this.slug_template.image.replace('{SLUG}', code.slug)

            if (!code.linkto) {
                baked_element = document.createElement('img')

                baked_element.setAttribute('src', code.slug)
                baked_element.setAttribute('loading', 'lazy')

                this.#add_code_attr(code, baked_element)
                this.#add_code_css(code, baked_element)

                if (!code.alt) {
                    baked_element.setAttribute('alt', code.slug.split('/').pop() ?? code.slug)
                }
                else {
                    baked_element.setAttribute('alt', code.alt)
                }
            }
            else {
                baked_element = document.createElement('a')

                baked_element.setAttribute('href', code.linkto)

                const inner1: HTMLImageElement = document.createElement('img')

                inner1.setAttribute('src', code.slug)
                inner1.setAttribute('loading', 'lazy')

                this.#add_code_attr(code, baked_element)
                this.#add_code_css(code, baked_element)

                if (!code.alt) {
                    inner1.setAttribute('alt', code.slug.split('/').pop() ?? code.slug)
                }
                else {
                    inner1.setAttribute('alt', code.alt)
                }

                baked_element.append(inner1)
            }
        }

        // audio
        if (code.type == 'audio') {
            code.slug = this.slug_template.audio.replace('{SLUG}', code.slug)

            if (!code.label) {
                baked_element = document.createElement('audio')

                baked_element.setAttribute('src', code.slug)
                baked_element.setAttribute('loading', 'lazy')
                baked_element.setAttribute('preload', 'metadata')
                baked_element.setAttribute('controls', 'controls')

                this.#add_code_attr(code, baked_element)
                this.#add_code_css(code, baked_element)

                const inner1: HTMLAnchorElement = document.createElement('a')
                inner1.setAttribute('href', code.slug)
                inner1.innerHTML = code.slug

                baked_element.append(inner1)
            }
            else {
                baked_element = document.createElement('div')

                const inner1: HTMLAnchorElement = document.createElement('a')
                inner1.innerHTML = code.label
                inner1.setAttribute('href', code.slug)

                baked_element.append(inner1)

                const inner2: HTMLAudioElement = document.createElement('audio')

                inner2.setAttribute('src', code.slug)
                inner2.setAttribute('loading', 'lazy')
                inner2.setAttribute('preload', 'metadata')
                inner2.setAttribute('controls', 'controls')

                this.#add_code_attr(code, inner2)
                this.#add_code_css(code, inner2)

                const inner3: HTMLAnchorElement = document.createElement('a')
                inner3.setAttribute('href', code.slug)
                inner3.innerHTML = code.slug

                inner2.append(inner3)
                baked_element.append(inner2)
            }
        }

        // video
        if (code.type == 'video') {
            code.slug = this.slug_template.video.replace('{SLUG}', code.slug)

            baked_element = document.createElement('div')
            baked_element.classList.add(this.videobox_class)

            const inner1: HTMLVideoElement = document.createElement('video')

            inner1.setAttribute('src', code.slug)
            inner1.setAttribute('loading', 'lazy')
            inner1.setAttribute('preload', 'metadata')
            inner1.setAttribute('controls', 'controls')
            inner1.setAttribute('playsinline', 'playsinline')

            this.#add_code_attr(code, inner1)
            this.#add_code_css(code, inner1)

            const inner2: HTMLAnchorElement = document.createElement('a')
            inner2.setAttribute('href', code.slug)
            inner2.innerHTML = code.slug

            inner1.append(inner2)
            baked_element.append(inner1)
        }

        // bandcamptrack
        if (code.type == 'bandcamptrack') {
            code.slug = this.slug_template.bandcamptrack.replace('{SLUG}', code.slug)

            baked_element = document.createElement('iframe')

            baked_element.setAttribute('src', code.slug)
            baked_element.setAttribute('loading', 'lazy')

            this.#add_code_attr(code, baked_element)
            this.#add_code_css(code, baked_element)
        }

        // bandcampalbum
        if (code.type == 'bandcampalbum') {
            code.slug = this.slug_template.bandcampalbum.replace('{SLUG}', code.slug)

            if (!code.trackcount) {
                code.slug = code.slug.replace('tracklist=true', 'tracklist=false')
            }

            baked_element = document.createElement('iframe')

            baked_element.setAttribute('src', code.slug)
            baked_element.setAttribute('loading', 'lazy')

            this.#add_code_attr(code, baked_element)
            this.#add_code_css(code, baked_element)

            if (code.trackcount) {
                baked_element.style.height = `${Math.round(this.bandcamp_list_height.header + (this.bandcamp_list_height.row * code.trackcount) + this.bandcamp_list_height.footer)}px`
            }
            else {
                baked_element.classList.add('notracklist')
            }
        }

        // spotifytrack
        if (code.type == 'spotifytrack') {
            code.slug = this.slug_template.spotifytrack.replace('{SLUG}', code.slug)

            if (code.usetheme) {
                code.slug = code.slug.replace('theme=0', 'theme=1')
            }

            baked_element = document.createElement('iframe')

            baked_element.setAttribute('src', code.slug)
            baked_element.setAttribute('loading', 'lazy')

            this.#add_code_attr(code, baked_element)
            this.#add_code_css(code, baked_element)
        }

        // spotifyalbum
        if (code.type == 'spotifyalbum') {
            code.slug = this.slug_template.spotifyalbum.replace('{SLUG}', code.slug)

            if (code.usetheme) {
                code.slug = code.slug.replace('theme=0', 'theme=1')
            }

            baked_element = document.createElement('iframe')

            baked_element.setAttribute('src', code.slug)
            baked_element.setAttribute('loading', 'lazy')

            this.#add_code_attr(code, baked_element)
            this.#add_code_css(code, baked_element)

            if (code.trackcount) {
                baked_element.style.height = `${Math.round(this.spotify_list_height.header + (this.spotify_list_height.row * code.trackcount) + this.spotify_list_height.footer)}px`
            }
        }

        // spotifyplaylist
        if (code.type == 'spotifyplaylist') {
            code.slug = this.slug_template.spotifyplaylist.replace('{SLUG}', code.slug)

            if (code.usetheme) {
                code.slug = code.slug.replace('theme=0', 'theme=1')
            }

            baked_element = document.createElement('iframe')

            baked_element.setAttribute('src', code.slug)
            baked_element.setAttribute('loading', 'lazy')

            this.#add_code_attr(code, baked_element)
            this.#add_code_css(code, baked_element)

            if (code.trackcount) {
                baked_element.style.height = `${Math.round(this.spotify_list_height.header + (this.spotify_list_height.row * code.trackcount) + this.spotify_list_height.footer)}px`
            }
        }

        // mixcloudshow
        if (code.type == 'mixcloudshow') {
            code.slug = this.slug_template.mixcloudshow.replace('{SLUG}', code.slug)

            baked_element = document.createElement('iframe')

            baked_element.setAttribute('src', code.slug)
            baked_element.setAttribute('loading', 'lazy')

            this.#add_code_attr(code, baked_element)
            this.#add_code_css(code, baked_element)
        }

        // mixcloudplaylist
        if (code.type == 'mixcloudplaylist') {
            code.slug = this.slug_template.mixcloudplaylist.replace('{SLUG}', code.slug)

            baked_element = document.createElement('iframe')

            baked_element.setAttribute('src', code.slug)
            baked_element.setAttribute('loading', 'lazy')

            this.#add_code_attr(code, baked_element)
            this.#add_code_css(code, baked_element)
        }

        // youtubevideo
        if (code.type == 'youtubevideo') {
            code.slug = this.slug_template.youtubevideo.replace('{SLUG}', code.slug)

            if (code.start) {
                code.slug = code.slug.replace('start=0', `start=${code.start}`)
            }

            baked_element = document.createElement('div')
            baked_element.classList.add(this.videobox_class)

            const inner1: HTMLIFrameElement = document.createElement('iframe')

            inner1.setAttribute('src', code.slug)
            inner1.setAttribute('loading', 'lazy')
            inner1.setAttribute('allowfullscreen', 'allowfullscreen')
            inner1.setAttribute('playsinline', 'playsinline')

            this.#add_code_attr(code, inner1)
            this.#add_code_css(code, inner1)

            baked_element.append(inner1)
        }

        // youtubeplaylist
        if (code.type == 'youtubeplaylist') {
            code.slug = this.slug_template.youtubeplaylist.replace('{SLUG}', code.slug)

            baked_element = document.createElement('div')
            baked_element.classList.add(this.videobox_class)

            const inner1: HTMLIFrameElement = document.createElement('iframe')

            inner1.setAttribute('src', code.slug)
            inner1.setAttribute('loading', 'lazy')
            inner1.setAttribute('allowfullscreen', 'allowfullscreen')
            inner1.setAttribute('playsinline', 'playsinline')

            this.#add_code_attr(code, inner1)
            this.#add_code_css(code, inner1)

            baked_element.append(inner1)
        }

        // odyseevideo
        if (code.type == 'odyseevideo') {
            code.slug = this.slug_template.odyseevideo.replace('{SLUG}', code.slug)

            baked_element = document.createElement('div')
            baked_element.classList.add(this.videobox_class)

            const inner1: HTMLIFrameElement = document.createElement('iframe')

            inner1.setAttribute('src', code.slug)
            inner1.setAttribute('loading', 'lazy')
            inner1.setAttribute('allowfullscreen', 'allowfullscreen')
            inner1.setAttribute('playsinline', 'playsinline')

            this.#add_code_attr(code, inner1)
            this.#add_code_css(code, inner1)

            baked_element.append(inner1)
        }

        return baked_element
    }


    #add_code_attr(code: LazyCode, baked_element: HTMLElement): void
    {
        if (code.attr) {
            for (const [k, v] of code.attr) {
                if (v !== null) {
                    baked_element.setAttribute(k, v)
                }
                else {
                    baked_element.removeAttribute(k)
                }
            }
        }
    }


    #add_code_css(code: LazyCode, baked_element: HTMLElement): void
    {
        baked_element.classList.add('lazymedia', code.type)

        if (code.class) {
            baked_element.classList.add(...code.class)
        }
    }
}
