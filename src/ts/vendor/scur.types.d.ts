interface ScurInterface {
    // Salt string
    s: string

    // Obscure a string
    // ob(data: string): string

    // Deobscure a string
    deob(data: string): string

    // Deobscure HTML elements
    deobElements(): void

    // Reverse a string
    _r(data: string): string
}
