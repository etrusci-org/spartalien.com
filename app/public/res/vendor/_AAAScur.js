export const Scur = {
    s: '745d328ed27746ca8803c4ba1571dd731418365f67fe41c7ad9765981fcac618',
    deob(data) {
        return this._r(atob(this._r(data))).replace(this.s, '');
    },
    deobElements() {
        let nodeList = document.querySelectorAll('[data-scur]');
        if (nodeList instanceof NodeList) {
            nodeList.forEach(node => {
                if (node instanceof HTMLElement &&
                    node.dataset['scur'] !== undefined) {
                    if (node instanceof HTMLAnchorElement) {
                        node.setAttribute('href', Scur.deob(node.dataset['scur']));
                    }
                    else {
                        node.innerHTML = Scur.deob(node.dataset['scur']);
                    }
                    delete node.dataset['scur'];
                }
            });
        }
    },
    _r(data) {
        return data.split('').reverse().join('');
    },
};
