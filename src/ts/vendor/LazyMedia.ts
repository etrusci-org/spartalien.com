interface LazyMediaInterface {
    debug: boolean
    selector: string
    slugTpl: {
        link: string
        image: string
        audio: string
        video: string
        bandcampTrack: string
        bandcampAlbum: string
        spotifyTrack: string
        spotifyAlbum: string
        spotifyPlaylist: string
        mixcloudMix: string
        mixcloudPlaylist: string
        youtubeVideo: string
        youtubePlaylist: string
        twitchStream: string
        twitchChat: string
    }
    bandcampAlbumHeight: {
        header: number
        trackRow: number
        bottomBar: number
    }
    spotifyAlbumHeight: {
        header: number
        trackRow: number
        bottomBar: number
    }
    spotifyPlaylistHeight: {
        header: number
        trackRow: number
        bottomBar: number
    }
    embed(): void
    bake(code: lazyCodeType, targetNode: HTMLElement): HTMLElement | null
    bakeLink(code: lazyCodeType): HTMLAnchorElement | null
    bakeImage(code: lazyCodeType): HTMLImageElement | null
    bakeAudio(code: lazyCodeType): HTMLAudioElement | null
    bakeVideo(code: lazyCodeType): HTMLVideoElement | null
    bakeBandcampTrack(code: lazyCodeType): HTMLIFrameElement | null
    bakeBandcampAlbum(code: lazyCodeType): HTMLIFrameElement | null
    bakeSpotifyTrack(code: lazyCodeType): HTMLIFrameElement | null
    bakeSpotifyAlbum(code: lazyCodeType): HTMLIFrameElement | null
    bakeSpotifyPlaylist(code: lazyCodeType): HTMLIFrameElement | null
    bakeMixcloudMix(code: lazyCodeType): HTMLIFrameElement | null
    bakeMixcloudPlaylist(code: lazyCodeType): HTMLIFrameElement | null
    bakeYoutubeVideo(code: lazyCodeType): HTMLIFrameElement | null
    bakeYoutubePlaylist(code: lazyCodeType): HTMLIFrameElement | null
    bakeTwitchStream(code: lazyCodeType): HTMLIFrameElement | null
    bakeTwitchChat(code: lazyCodeType): HTMLIFrameElement | null
    guessHTMLAudioTypeByExt(filename: string): string | null
    guessHTMLVideoTypeByExt(filename: string): string | null
}


type lazyCodeType = {
    type: string
    slug: string
    attr?: [string, string | false ][]
    data?: [string, string | false ][]
    text?: string // for: link
    trackCount?: number // for: bandcampAlbum
    timeStart?: number // for: youtubeVideo
    disableTheme?: boolean // for: spotifyTrack, spotifyAlbum, spotifyPlaylist
}




export const LazyMedia: LazyMediaInterface = {
    debug: false,
    selector: '.lazycode',
    slugTpl: {
        /* brain for docs:

        bandcamp
            track slug: <track_id>
            album slug: <album_id>

        spotify
            track slug: <track_id>
            album slug: <album_id>
            playlilst slug: <album_id>

        mixcloud
            mix slug: /<profile>/<show>/
            playlist slug: /<profile>/playlists/<playlist>/

        youtube
            video slug: <video_id>
            playlist slug: <playlist_id>

        twitch
            stream slug: <channel>&parent=<your_domain>
            chat slug: <channel>/chat?[darkpopout&]parent=<your_domain>
        */
        link: '{SLUG}',
        image: '{SLUG}',
        audio: '{SLUG}',
        video: '{SLUG}',
        bandcampTrack: '//bandcamp.com/EmbeddedPlayer/track={SLUG}/size=large/artwork=none/bgcol=2b2b2b/linkcol=cccccc/tracklist=false/transparent=true/',
        bandcampAlbum: '//bandcamp.com/EmbeddedPlayer/album={SLUG}/size=large/artwork=none/bgcol=2b2b2b/linkcol=cccccc/tracklist=true/transparent=true/',
        spotifyTrack: '//open.spotify.com/embed/track/{SLUG}',
        spotifyAlbum: '//open.spotify.com/embed/album/{SLUG}',
        spotifyPlaylist: '//open.spotify.com/embed/playlist/{SLUG}',
        mixcloudMix: '//www.mixcloud.com/widget/iframe/?feed={SLUG}&hide_cover=1&hide_artwork=0',
        mixcloudPlaylist: '//www.mixcloud.com/widget/iframe/?feed={SLUG}&hide_cover=1&hide_artwork=0',
        youtubeVideo: '//youtube.com/embed/{SLUG}?modestbranding=1&rel=0',
        youtubePlaylist: '//youtube.com/embed/videoseries?list={SLUG}&modestbranding=1&rel=0',
        twitchStream: '//player.twitch.tv/?muted=false&autoplay=true&channel={SLUG}',
        twitchChat: '//twitch.tv/embed/{SLUG}',
    },
    bandcampAlbumHeight: {
        header: 119,
        trackRow: 32,
        bottomBar: 64,
    },
    spotifyAlbumHeight: {
        header: 80,
        trackRow: 31,
        bottomBar: 10,
    },
    spotifyPlaylistHeight: {
        header: 80,
        trackRow: 50,
        bottomBar: 10,
    },


    embed() {
        if (this.debug) console.group('LazyMedia')

        const targetNodes = document.querySelectorAll(this.selector)

        targetNodes.forEach(targetNode => {
            if (targetNode instanceof HTMLElement) {
                try {
                    const code: lazyCodeType = JSON.parse(targetNode.innerText)
                    const e = this.bake(code, targetNode)

                    if (e) {
                        if (this.debug) console.debug('targetNode:', targetNode, '\nlazycode:', code, '\nbaked element:', e)
                        targetNode.replaceWith(e)
                    }
                }
                catch (error) {
                    console.error('BOO!\n\ncode:', targetNode.innerText.trim(), '\n\ntargetNode:', targetNode, '\n\nerror message:', error)
                }
            }
        })

        if (this.debug) console.groupEnd()
    },


    bake(code, targetNode) {
        let e = null

        if (code.type == 'link') e = this.bakeLink(code)
        if (code.type == 'image') e = this.bakeImage(code)
        if (code.type == 'audio') e = this.bakeAudio(code)
        if (code.type == 'video') e = this.bakeVideo(code)
        if (code.type == 'bandcampTrack') e = this.bakeBandcampTrack(code)
        if (code.type == 'bandcampAlbum') e = this.bakeBandcampAlbum(code)
        if (code.type == 'spotifyTrack') e = this.bakeSpotifyTrack(code)
        if (code.type == 'spotifyAlbum') e = this.bakeSpotifyAlbum(code)
        if (code.type == 'spotifyPlaylist') e = this.bakeSpotifyPlaylist(code)
        if (code.type == 'mixcloudMix') e = this.bakeMixcloudMix(code)
        if (code.type == 'mixcloudPlaylist') e = this.bakeMixcloudPlaylist(code)
        if (code.type == 'youtubeVideo') e = this.bakeYoutubeVideo(code)
        if (code.type == 'youtubePlaylist') e = this.bakeYoutubePlaylist(code)
        if (code.type == 'twitchStream') e = this.bakeTwitchStream(code)
        if (code.type == 'twitchChat') e = this.bakeTwitchChat(code)

        // post process baked elements
        if (e) {
            // keep existing css classes
            e.classList.add(...targetNode.classList)

            // remove selector css class
            e.classList.remove(this.selector.substring(1))

            // add helper css classes
            e.classList.add('lazymedia', code.type)

            // keep existing dataset
            for (const k in targetNode.dataset) {
                e.dataset[k] = targetNode.dataset[k]
            }

            // add/remove attributes
            if (code.attr) {
                for (const [k, v] of code.attr) {
                    if (v !== false) {
                        e.setAttribute(k, v.toString())
                    }
                    else {
                        e.removeAttribute(k)
                    }
                }
            }

            // add/remove dataset entries
            if (code.data) {
                for (const [k, v] of code.data) {
                    if (v !== false) {
                        e.dataset[k] = v.toString()
                    }
                    else {
                        delete e.dataset[k]
                    }
                }
            }
        }

        return e
    },


    bakeLink(code) {
        const e = document.createElement('a')

        e.setAttribute('href', this.slugTpl.link.replace('{SLUG}', code.slug))

        if (code.text) {
            e.innerText = code.text
        }
        else {
            e.innerText = this.slugTpl.link.replace('{SLUG}', code.slug.split('//').pop() || code.slug)
        }

        return e
    },


    bakeImage(code) {
        const e = document.createElement('img')

        e.setAttribute('loading', 'lazy')
        e.setAttribute('src', this.slugTpl.image.replace('{SLUG}', code.slug))
        e.setAttribute('alt', code.slug.split('/').pop() || code.slug)

        return e
    },


    bakeAudio(code) {
        const e  = document.createElement('audio')
        const e2 = document.createElement('source')

        e.setAttribute('preload', 'metadata')
        e.setAttribute('controls', 'controls')

        e2.setAttribute('src', this.slugTpl.audio.replace('{SLUG}', code.slug))
        const audioType = this.guessHTMLAudioTypeByExt(code.slug)
        if (audioType) {
            e2.setAttribute('type', audioType)
        }

        e.appendChild(e2)

        return e
    },


    bakeVideo(code) {
        const e  = document.createElement('video')
        const e2 = document.createElement('source')

        e.setAttribute('preload', 'metadata')
        e.setAttribute('controls', 'controls')
        e.setAttribute('playsinline', 'playsinline')

        e2.setAttribute('src', this.slugTpl.video.replace('{SLUG}', code.slug))
        const videoType = this.guessHTMLVideoTypeByExt(code.slug)
        if (videoType) {
            e2.setAttribute('type', videoType)
        }

        e.appendChild(e2)

        return e
    },


    bakeBandcampTrack(code) {
        const e = document.createElement('iframe')

        e.setAttribute('loading', 'lazy')
        e.setAttribute('src', this.slugTpl.bandcampTrack.replace('{SLUG}', code.slug))

        return e
    },


    bakeBandcampAlbum(code) {
        const e = document.createElement('iframe')

        if (!code.trackCount) {
            e.classList.add('noTracklist')
            this.slugTpl.bandcampAlbum = this.slugTpl.bandcampAlbum.replace('tracklist=true', 'tracklist=false')
        }

        e.setAttribute('loading', 'lazy')
        e.setAttribute('src', this.slugTpl.bandcampAlbum.replace('{SLUG}', code.slug))

        if (code.trackCount) {
            e.style.height = `${Math.round(this.bandcampAlbumHeight.header + (this.bandcampAlbumHeight.trackRow * code.trackCount) + this.bandcampAlbumHeight.bottomBar)}px`
        }

        return e
    },


    bakeSpotifyTrack(code) {
        const e = document.createElement('iframe')

        if (code.disableTheme) this.slugTpl.spotifyTrack = `${this.slugTpl.spotifyTrack}?theme=0`

        e.setAttribute('loading', 'lazy')
        e.setAttribute('src', this.slugTpl.spotifyTrack.replace('{SLUG}', code.slug))

        return e
    },


    bakeSpotifyAlbum(code) {
        const e = document.createElement('iframe')

        if (code.disableTheme) this.slugTpl.spotifyAlbum = `${this.slugTpl.spotifyAlbum}?theme=0`

        e.setAttribute('loading', 'lazy')
        e.setAttribute('src', this.slugTpl.spotifyAlbum.replace('{SLUG}', code.slug))

        if (code.trackCount) {
            e.style.height = `${Math.round(this.spotifyAlbumHeight.header + (this.spotifyAlbumHeight.trackRow * code.trackCount) + this.spotifyAlbumHeight.bottomBar)}px`
        }

        return e
    },


    bakeSpotifyPlaylist(code) {
        const e = document.createElement('iframe')

        if (code.disableTheme) this.slugTpl.spotifyPlaylist = `${this.slugTpl.spotifyPlaylist}?theme=0`

        e.setAttribute('loading', 'lazy')
        e.setAttribute('src', this.slugTpl.spotifyPlaylist.replace('{SLUG}', code.slug))

        if (code.trackCount) {
            e.style.height = `${Math.round(this.spotifyPlaylistHeight.header + (this.spotifyPlaylistHeight.trackRow * code.trackCount) + this.spotifyPlaylistHeight.bottomBar)}px`
        }

        return e
    },


    bakeMixcloudMix(code) {
        const e = document.createElement('iframe')

        e.setAttribute('loading', 'lazy')
        e.setAttribute('src', this.slugTpl.mixcloudMix.replace('{SLUG}', code.slug))

        return e
    },


    bakeMixcloudPlaylist(code) {
        const e = document.createElement('iframe')

        e.setAttribute('loading', 'lazy')
        e.setAttribute('src', this.slugTpl.mixcloudPlaylist.replace('{SLUG}', code.slug))

        return e
    },


    bakeYoutubeVideo(code) {
        const e = document.createElement('iframe')

        if (code.timeStart) this.slugTpl.youtubeVideo = `${this.slugTpl.youtubeVideo}&start=${code.timeStart}`

        e.setAttribute('loading', 'lazy')
        e.setAttribute('src', this.slugTpl.youtubeVideo.replace('{SLUG}', code.slug))
        e.setAttribute('allowfullscreen', 'allowfullscreen')
        e.setAttribute('playsinline', 'playsinline')

        return e
    },


    bakeYoutubePlaylist(code) {
        const e = document.createElement('iframe')

        e.setAttribute('loading', 'lazy')
        e.setAttribute('src', this.slugTpl.youtubePlaylist.replace('{SLUG}', code.slug))
        e.setAttribute('allowfullscreen', 'allowfullscreen')
        e.setAttribute('playsinline', 'playsinline')

        console.log('e :>> ', e);

        return e
    },


    bakeTwitchStream(code) {
        const e = document.createElement('iframe')

        e.setAttribute('loading', 'lazy')
        e.setAttribute('src', this.slugTpl.twitchStream.replace('{SLUG}', code.slug))
        e.setAttribute('allowfullscreen', 'allowfullscreen')

        return e
    },


    bakeTwitchChat(code) {
        const e = document.createElement('iframe')

        e.setAttribute('loading', 'lazy')
        e.setAttribute('src', this.slugTpl.twitchChat.replace('{SLUG}', code.slug))

        return e
    },


    guessHTMLAudioTypeByExt(filename) {
        let audioType = null
        const audioExt = filename.split('.').pop()

        if (audioExt == 'mp3') {
            audioType = 'audio/mpeg'
        }

        if (audioExt == 'ogg') {
            audioType = 'audio/ogg'
        }

        if (audioExt == 'wav') {
            audioType = 'audio/wav'
        }

        return audioType
    },


    guessHTMLVideoTypeByExt(filename) {
        let videoType = null
        const videoExt = filename.split('.').pop()

        if (videoExt == 'mp4') {
            videoType = 'video/mp4'
        }

        if (videoExt == 'webm') {
            videoType = 'video/webm'
        }

        if (videoExt == 'ogv') {
            videoType = 'video/ogg'
        }

        return videoType
    },
}
