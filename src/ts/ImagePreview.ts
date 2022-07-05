// My first attempt at making a modal image preview. Still WIP.
// Ditched Lightbox2 because it depends on a 3rd party lib.

// What I miss:
// - horizontally and vertically center target container
// - optional title and description in target container
// - optional file info in target container

// HTML:
// <a href="foo-big.jpg" class="imagepreview"><img src="foo-small.jpg"></a>

// SCSS:
// .imagepreviewTarget {
//     display: none;
//     position: fixed;
//     top: 0;
//     bottom: 0;
//     left: 0;
//     right: 0;
//     z-index: 2000;
//     text-align: center;
//     &.open {
//         display: block;
//     }
//     img {
//         max-width: 100%;
//         max-height: 100%;
//     }
// }





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

        if (!this.target) return

        this.nodes.forEach((nodeElement) => {
            nodeElement.addEventListener('click', (event) => {
                let img = new Image()
                let imgSrc = nodeElement.getAttribute('href')

                if (!imgSrc) return

                img.setAttribute('src', imgSrc)

                if (!this.target) return

                this.target.replaceChildren(img)
                this.target.classList.add('open')

                document.body.style.overflow = 'hidden'

                event.preventDefault()
            }, false)
        })

        this.target.addEventListener('click', (event) => {
            this.close(event)
        }, false)

        window.addEventListener('keydown', (event) => {
            if (event.key != 'Escape') return
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
