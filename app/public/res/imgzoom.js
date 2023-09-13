export class ImgZoom {
    target_selector = 'div.imgzoom-target';
    node_selector = 'a.imgzoom, a.lazymedia.image';
    target_element;
    nodes;
    constructor() {
        this.target_element = document.querySelector(this.target_selector);
        this.nodes = document.querySelectorAll(this.node_selector);
        this.nodes.forEach((node_element) => {
            node_element.addEventListener('click', (event) => {
                event.preventDefault();
                console.log(node_element);
                const img = new Image();
                img.setAttribute('src', node_element.getAttribute('href') || '');
                this.target_element.replaceChildren(img);
                this.target_element.classList.add('open');
                document.body.style.overflow = 'hidden';
            }, false);
        });
        this.target_element.addEventListener('click', (event) => {
            event.preventDefault();
            this.close();
        }, false);
        window.addEventListener('keydown', (event) => {
            if (event.key == 'Escape' || event.key == ' ') {
                this.close();
            }
        }, false);
    }
    close() {
        this.target_element.classList.remove('open');
        this.target_element.innerHTML = '';
        document.body.style.overflow = 'auto';
    }
}
