export class BGColorFader {
    queue: string[]
    color_list: string[]


    constructor(color_list: string[]) {
        this.queue = []
        this.color_list = color_list

        document.body.style.transition = 'background-color 5.0s linear 0.0s'

        document.body.addEventListener('transitionend', () => {
            this.update()
        })
    }


    start(): void
    {
        this.update()
    }


    update(): void
    {
        if (this.queue.length == 0) {
            for (const item of this.color_list) {
                const value = item.trim()
                if (value) {
                    this.queue.push(`${value}`)
                }
            }
        }

        console.debug('BGColorFader update()', this.queue.splice(0, 1)[0])

        document.body.style.backgroundColor = `${this.queue.splice(0, 1)[0]}`
    }
}
