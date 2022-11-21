interface AppInterface {
    main(routeRequest: string): void
    // loadRandomTrack(target: HTMLDivElement|null): void
}

interface ImagePreviewInterface {
    targetSelector: string
    nodeSelector: string
    target: HTMLDivElement | null
    nodes: NodeListOf<HTMLAnchorElement> | null
    init(): void
    close(event: Event): void
}
