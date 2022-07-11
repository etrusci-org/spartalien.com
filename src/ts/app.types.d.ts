interface AppInterface {
    main(routeRequest: string): void
}

interface RandomQuoteTyperInterface {
    typingSpeed: number
    targetSelector: string
    target: HTMLDivElement | HTMLParagraphElement | HTMLSpanElement | HTMLAnchorElement | null
    queue: RandomQuoteItemType[]
    quote: RandomQuoteItemType
    typerID: number | null
    init(): void
    typeQuote(): void
    stop(): void
    _fys(arr: any[]): any[] // https://en.wikipedia.org/wiki/Fisher-Yates_algorithm
}

type RandomQuoteItemType = { author: string, text: string } | null

type RandomQuoteArrayType = RandomQuoteItemType[]
