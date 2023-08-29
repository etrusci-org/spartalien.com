interface ScurInterface {
    s: string
    // ob(data: string): string
    deob(data: string): string
    deobElements(): void
    _r(data: string): string
}


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
        odyseeVideo: string
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
    bakeYoutubePlaylist(code: lazyCodeType): HTMLDivElement | null
    bakeTwitchStream(code: lazyCodeType): HTMLIFrameElement | null
    bakeTwitchChat(code: lazyCodeType): HTMLIFrameElement | null
    bakeOdyseeVideo(code: lazyCodeType): HTMLIFrameElement | null
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


interface ImgPrevInterface {
    targetSelector: string
    nodeSelector: string
    target: HTMLDivElement | null
    nodes: NodeListOf<HTMLAnchorElement> | null
    init(): void
    close(event: Event): void
}


// type BGColorFader_queue_type = string[]
// type BGColorFader_color_list_type = string[]
