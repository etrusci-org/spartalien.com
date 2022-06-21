interface ScurInterface {
    // Salt string
    s: string

    // Deobscure a string
    deob(data: string): string

    // Deobscure HTML elements
    deobElements(): void

    // Reverse a string
    _r(data: string): string
}
