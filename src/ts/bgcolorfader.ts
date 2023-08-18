export class BGColorFader {
    queue: BGColorFader_queue_type
    color_list: BGColorFader_color_list_type


    constructor(color_list: BGColorFader_color_list_type) {
        this.queue = []
        this.color_list = color_list

        document.body.style.transition = 'background-color 5.0s ease 0.0s'

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
                    this.queue.push(`#${value}`)
                }
            }
        }

        document.body.style.backgroundColor = this.queue.splice(0, 1)[0] || 'currentColor'
    }
}
