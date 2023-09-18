export class ImgZoom
{
    public target_selector: string = 'div.imgzoom-target'
    public node_selector: string = 'a.imgzoom, a.lazymedia.image'

    private target_element: HTMLDivElement
    private nodes: NodeListOf<HTMLAnchorElement>


    constructor()
    {
        this.target_element = document.querySelector(this.target_selector) as HTMLDivElement
        this.nodes = document.querySelectorAll(this.node_selector)
    }


    public init(): void
    {
        this.nodes.forEach((node_element) => {
            node_element.addEventListener('click', (event) => {
                event.preventDefault()

                // create image element
                const img = new Image()
                img.setAttribute('src', node_element.getAttribute('href') || '')

                // insert image element into target element
                this.target_element.replaceChildren(img)

                // make target element visible
                this.target_element.classList.add('open')

                // prevent scrollbars
                document.body.style.overflow = 'hidden'
            }, false)
        })

        this.target_element.addEventListener('click', (event) => {
            event.preventDefault()
            this.close()
        }, false)

        window.addEventListener('keydown', (event) => {
            if (['Escape', 'x', 'c', ' '].includes(event.key)) {
                this.close()
            }
        }, false)
    }


    public close(): void
    {
        this.target_element.classList.remove('open')
        this.target_element.innerHTML = ''
        document.body.style.overflow = 'auto'
    }
}
