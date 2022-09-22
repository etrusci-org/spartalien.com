interface AppInterface {
    main(routeRequest: string): void
    loadRandomTrack(target: HTMLDivElement|null): void
    loadRandomQuote(): void
}

interface ImagePreviewInterface {
    targetSelector: string
    nodeSelector: string
    target: HTMLDivElement | null
    nodes: NodeListOf<HTMLAnchorElement> | null
    init(): void
    close(event: Event): void
}

interface RandomQuoteTyperInterface {
    typingSpeed: number
    targetSelector: string
    target: HTMLDivElement | HTMLParagraphElement | HTMLSpanElement | HTMLAnchorElement | null
    queue: QuoteItemType[]
    quote: QuoteItemType
    typerID: number | null
    init(): void
    typeQuote(): void
    stop(): void
    _fys(arr: any[]): any[] // https://en.wikipedia.org/wiki/Fisher-Yates_algorithm
}

type QuoteItemType = { author: string, text: string } | null

type QuoteArrayType = QuoteItemType[]
