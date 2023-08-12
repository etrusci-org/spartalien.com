export const ImgPrev: ImgPrevInterface = {
    targetSelector: 'div.imgprev-target',
    nodeSelector: 'a.imgprev',
    target: null,
    nodes: null,


    init() {
        this.target = document.querySelector(this.targetSelector)
        this.nodes = document.querySelectorAll(this.nodeSelector)

        if (!this.target || !this.nodes) return

        this.nodes.forEach((nodeElement) => {
            nodeElement.addEventListener('click', (event) => {
                // create image
                const img = new Image()
                const imgSrc = nodeElement.getAttribute('href')
                if (!imgSrc) return
                img.setAttribute('src', imgSrc)

                // insert img into target
                if (!this.target) return
                this.target.replaceChildren(img)

                // make target visible
                this.target.classList.add('open')

                // prevent scrollbars
                document.body.style.overflow = 'hidden'

                // prevent following the link
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
