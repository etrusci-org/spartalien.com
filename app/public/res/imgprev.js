export const ImgPrev = {
    targetSelector: 'div.imgprev-target',
    nodeSelector: 'a.imgprev',
    target: null,
    nodes: null,
    init() {
        this.target = document.querySelector(this.targetSelector);
        this.nodes = document.querySelectorAll(this.nodeSelector);
        if (!this.target || !this.nodes)
            return;
        this.nodes.forEach((nodeElement) => {
            nodeElement.addEventListener('click', (event) => {
                const img = new Image();
                const imgSrc = nodeElement.getAttribute('href');
                if (!imgSrc)
                    return;
                img.setAttribute('src', imgSrc);
                if (!this.target)
                    return;
                this.target.replaceChildren(img);
                this.target.classList.add('open');
                document.body.style.overflow = 'hidden';
                event.preventDefault();
            }, false);
        });
        this.target.addEventListener('click', (event) => {
            this.close(event);
        }, false);
        window.addEventListener('keydown', (event) => {
            if (event.key != 'Escape')
                return;
            this.close(event);
        }, false);
    },
    close(event) {
        if (!this.target)
            return;
        this.target.classList.remove('open');
        this.target.innerHTML = '';
        document.body.style.overflow = 'auto';
        event.preventDefault();
    },
};
