export const Scur = {
    s: '6b519c1d-ca51-4E42-9cce-ffd4a28b0ec0*4E9C7303-Dbe4-4b66-A8fd-B1535D7FA2DE$6c63bd76-54b8-4b4a-a395-ED310E15DF82',


    ob(data: string): string {
        let hash: string = this._r(btoa(this._r(this.s + data)))

        const dump: number[] = []
        hash.split('').forEach((v) => {
            dump.push(v.charCodeAt(0))
        })
        hash = dump.join('|')

        return hash
    },


    deob(data: string): string {
        const dump: string[] = []
        data.split('|').forEach((v) => {
            dump.push(String.fromCharCode(parseInt(v)))
        })

        const text: string = this._r(atob(this._r(dump.join(''))))

        if (text.indexOf(this.s) == -1) {
            console.error('Invalid or missing salt')
            return data
        }

        return text.replace(this.s, '')
    },


    autodeob(): void {
        const nodeList: NodeListOf<Element> = document.querySelectorAll('[data-scur]')
        if (nodeList instanceof NodeList) {
            nodeList.forEach(node => {
                if (
                    node instanceof HTMLElement
                    && node.dataset['scur'] !== undefined
                ) {
                    if (node instanceof HTMLAnchorElement) {
                        node.setAttribute('href', Scur.deob(node.dataset['scur']))
                    }
                    else {
                        node.innerHTML = Scur.deob(node.dataset['scur'])
                    }
                    delete node.dataset['scur']
                }
            })
        }
    },


    _r(data: string): string {
        return data.split('').reverse().join('')
    },
}
