export class Scur {
    s = '6b519c1d-ca51-4E42-9cce-ffd4a28b0ec0*4E9C7303-Dbe4-4b66-A8fd-B1535D7FA2DE$6c63bd76-54b8-4b4a-a395-ED310E15DF82';
    deob(data) {
        const dump = [];
        data.split('|').forEach((v) => {
            dump.push(String.fromCharCode(parseInt(v)));
        });
        const text = this.#_r(atob(this.#_r(dump.join(''))));
        if (text.indexOf(this.s) == -1) {
            console.error('Invalid or missing salt');
            return data;
        }
        return text.replace(this.s, '');
    }
    autodeob() {
        const nodeList = document.querySelectorAll('[data-scur]');
        nodeList.forEach(node => {
            if (node instanceof HTMLElement
                && node.dataset['scur'] !== undefined) {
                if (node instanceof HTMLAnchorElement) {
                    node.setAttribute('href', this.deob(node.dataset['scur']));
                }
                else {
                    node.innerHTML = this.deob(node.dataset['scur']);
                }
                delete node.dataset['scur'];
            }
        });
    }
    #_r(data) {
        return data.split('').reverse().join('');
    }
}
