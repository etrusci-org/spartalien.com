/**
 * Easily load lazy embeds.
 *
 * WORK IN PROGRESS!!
 */
 export const LazyMedia: LazyMediaInterface = {
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
        let nodes = document.querySelectorAll(this.selector)

        if (!nodes) {
            console.error('bad nodes:', nodes)
            return
        }

        nodes.forEach(node => {
            if (node instanceof HTMLElement) {

                let code: lazyCodeType = null

                try {
                    code = JSON.parse(node.innerHTML)

                    if (!code || !code.platform || !code.type || !code.slug) {
                        code = null
                        throw 'invalid JSON or missing platform, type or slug'
                    }
                }
                catch (error) {
                    console.error('bad code:', node.innerHTML, 'in node:', node, 'error message:', error)
                }

                if (code) {
                    // ----- CREATE BASIC ELEMENT DEPENDING ON PLATFORM AND TYPE -----
                    let e = null

                    // GENERIC
                    if (code.platform == 'generic') {
                        // link
                        if (code.type == 'link') {
                            e = this.createDefaultElement('a', node)
                            e.setAttribute('href', `${code.slug}${this.slugSuffix.generic.link}`)
                            e.innerText = (code.text) ? code.text : code.slug
                        }

                        // image
                        if (code.type == 'image') {
                            e = this.createDefaultElement('img', node)
                            e.setAttribute('src', `${code.slug}${this.slugSuffix.generic.image}`)
                            e.setAttribute('alt', code.slug.split('/').pop() || code.slug)
                        }

                        // audio
                        if (code.type == 'audio') {
                            e = this.createDefaultElement('audio', node)
                            e.setAttribute('preload', 'metadata')
                            e.setAttribute('controls', 'true')

                            let e2 = this.createDefaultElement('source')
                            e2.setAttribute('src', `${code.slug}${this.slugSuffix.generic.audio}`)

                            let audioType = null
                            let audioExt = code.slug.split('.').pop() || code.slug

                            if (audioExt == 'mp3') {
                                audioType = 'audio/mpeg'
                            }

                            if (audioExt == 'mp4') {
                                audioType = 'audio/mp4'
                            }

                            if (audioType) {
                                e2.setAttribute('type', audioType)
                            }

                            e.appendChild(e2)
                        }

                        // video
                        if (code.type == 'video') {
                            e = this.createDefaultElement('video', node)
                            e.setAttribute('preload', 'metadata')
                            e.setAttribute('controls', 'true')

                            let e2 = this.createDefaultElement('source')
                            e2.setAttribute('src', `${code.slug}${this.slugSuffix.generic.video}`)

                            let videoType = null
                            let videoExt = code.slug.split('.').pop() || code.slug

                            if (videoExt == 'mp4') {
                                videoType = 'video/mp4'
                            }

                            if (videoExt == 'webm') {
                                videoType = 'video/webm'
                            }

                            if (videoExt == 'ogv') {
                                videoType = 'video/ogg'
                            }

                            if (videoType) {
                                e2.setAttribute('type', videoType)
                            }

                            e.appendChild(e2)
                        }
                    }

                    // BANDCAMP
                    if (code.platform == 'bandcamp') {
                        e = this.createDefaultElement('iframe', node)

                        // track
                        if (code.type == 'track') {
                            e.setAttribute('src', `//bandcamp.com/EmbeddedPlayer/track=${code.slug}${this.slugSuffix.bandcamp.track}`)
                        }

                        // album
                        if (code.type == 'album') {
                            e.setAttribute('src', `//bandcamp.com/EmbeddedPlayer/album=${code.slug}${this.slugSuffix.bandcamp.album}`)

                            if (code.trackCount) {
                                e.style.height = `${Math.round(this.bandcampAlbumAutoHeight.header + (this.bandcampAlbumAutoHeight.trackRow * code.trackCount) + this.bandcampAlbumAutoHeight.bottomBar)}px`
                            }
                        }
                    }

                    // MIXCLOUD
                    if (code.platform == 'mixcloud') {
                        e = this.createDefaultElement('iframe', node)

                        if (code.type == 'mix') {
                            e.setAttribute('src', `//www.mixcloud.com/widget/iframe/?feed=${code.slug}${this.slugSuffix.mixcloud.mix}`)
                        }

                        if (code.type == 'playlist') {
                            e.setAttribute('src', `//www.mixcloud.com/widget/iframe/?feed=${code.slug}${this.slugSuffix.mixcloud.playlist}`)
                        }
                    }

                    // YOUTUBE
                    if (code.platform == 'youtube') {
                        e = this.createDefaultElement('iframe', node)
                        e.setAttribute('allowfullscreen', 'true')

                        if (code.type == 'video') {
                            if (code.timeStart) {
                                this.slugSuffix.youtube.video = `${this.slugSuffix.youtube.video}&t=${code.timeStart}`
                            }
                            e.setAttribute('src', `//www.youtube.com/embed/${code.slug}${this.slugSuffix.youtube.video}`)
                        }

                        if (code.type == 'playlist') {
                            e.setAttribute('src', `//www.youtube.com/embed/videoseries?list=${code.slug}${this.slugSuffix.youtube.playlist}`)
                        }
                    }

                    // ----- POST PROCESS CREATED ELEMENT -----
                    if (e) {
                        // Add platform/type css classes
                        e.classList.add(code.platform, code.type)

                        // // Add label if given
                        // if (code.label) {
                        //     let nodeLabel = this.createDefaultElement('label')
                        //     nodeLabel.innerText = code.label
                        //     node.insertAdjacentElement('beforebegin', nodeLabel)
                        // }
                        // else {
                        //     // Auto-label generic:audio
                        //     if (code.platform == 'generic' && code.type == 'audio') {
                        //         let nodeLabel = this.createDefaultElement('label')
                        //         nodeLabel.innerText = code.slug.split('/').pop() || code.slug
                        //         node.insertAdjacentElement('beforebegin', nodeLabel)
                        //     }
                        // }

                        // attribute
                        if (code.attribute) {
                            for (const [k, v] of code.attribute) {
                                if (v != 'false') {
                                    e.setAttribute(k, v)
                                }
                                else {
                                    e.removeAttribute(k)
                                }
                            }
                        }

                        // dataset
                        if (code.dataset) {
                            for (const [k, v] of code.dataset) {
                                e.dataset[k] = v
                            }
                        }

                        // EMBED FINAL THING
                        console.debug('[lazymedia]', 'code:', node.innerHTML, 'baked element:', e)
                        node.replaceWith(e)
                    }
                }
            }
        })
    },


    createDefaultElement(tag, targetNode) {
        let e = document.createElement(tag)

        // add default attributes for specific elements
        if (tag == 'iframe' || tag == 'img') {
            e.setAttribute('loading', 'lazy')
        }

        // process further if target node is given
        if (targetNode) {
            // keep targetNode dataset
            e.classList.add('lazymedia', ...targetNode.classList)

            // keep targetNode style
            let style = targetNode.getAttribute('style')
            if (style) {
                e.setAttribute('style', style)
            }
        }

        return e
    },
}


interface LazyMediaInterface {
    selector: string
    slugSuffix: {
        generic: {
            link: string
            image: string
            audio: string
            video: string
        }
        bandcamp: {
            track: string
            album: string
        }
        mixcloud: {
            mix: string
            playlist: string
        }
        youtube: {
            video: string
            playlist: string
        }
    }
    bandcampAlbumAutoHeight: {
        header: number,
        trackRow: number,
        bottomBar: number,
    }
    embed(): void
    createDefaultElement(tag: string, targetNode?: HTMLElement): HTMLElement
}


type lazyCodeType = {
    platform: string
    type: string
    slug: string
    attribute?: [string, string][]
    dataset?: [string, string][]
    text?: string
    // label?: string
    trackCount?: number
    timeStart?: number
} | null



/*
--- BRAIN FOR DOC LATER ---

    Mandatory:
        all:
            - platform
            - type
            - slug

    Optional:
        all:
            - attribute[]
            - dataset[]
            // - label
        generic link:
            - text
        bandcamp:
            - trackCount
        youtube video:
            - timeStart

    Example: {
        "platform": "generic",
        "type": "link",
        "slug": "//example.org",
        "text": "custom link text",
        "attribute": [
            ["target", "_blank"],
            ["title", "foobar"]
        ],
        "dataset": [
            ["cow", "moo"],
            ["cat", "miao"]
        ]
    }

* defaults ...
    class names existing already in the lazymedia element will be kept.
    e.g. in <div class="lazymedia foo bar">{...lazycode...}</div> foo and bar classes will be transfered to the embed element.

    styles existing already in the lazymedia element will be kept.
    e.g. in <div style="color:red;">{...lazycode...}</div> style will be transfered to the embed element.

    iframes and images:
        - loading=lazy

    generic:video and generic:audio...
        - preload=metadata
        - controls=true

    youtube:video and youtube:playlist
        - allowfullscreen=true


* set an attribute value to "false" to have it removed in case it's one added by default. like controls for video/audio.
  e.g. ["controls", "false"]
*/
