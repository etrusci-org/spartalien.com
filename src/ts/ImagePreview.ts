interface ImagePreviewInterface {
    targetSelector: string
    nodeSelector: string
    target: HTMLDivElement | null
    nodes: NodeListOf<HTMLAnchorElement> | null
    init(): void
    close(event: Event): void
}




export const ImagePreview: ImagePreviewInterface = {
    targetSelector: 'div.imagepreviewTarget',
    nodeSelector: 'a.imagepreview',
    target: null,
    nodes: null,


    init() {
        this.target = document.querySelector(this.targetSelector)
        this.nodes = document.querySelectorAll(this.nodeSelector)

        this.nodes.forEach((nodeElement) => {
            nodeElement.addEventListener('click', (event) => {
                let elementToInsert = document.createElement('img')
                let elementHref = nodeElement.getAttribute('href')
                if (!elementHref) return

                elementToInsert.setAttribute('src', elementHref)
                elementToInsert.setAttribute('alt', elementHref.split('/').pop() || elementHref)

                if (!this.target) return

                this.target.replaceChildren(elementToInsert)
                this.target.classList.add('open')

                document.body.style.overflow = 'hidden'

                event.preventDefault()
            }, false)
        })

        if (!this.target) return

        this.target.addEventListener('click', (event) => {
            this.close(event)
        }, false)

        window.addEventListener('keydown', (event) => {
            this.close(event)
        }, false)
    },


    close(event) {
        if (!this.target) return
        this.target.classList.remove('open')
        this.target.innerHTML = ''
        document.body.style.overflow = 'auto'
        event.preventDefault()
    },
}
