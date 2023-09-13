export class ElFilter {
    input_selector = 'input.elfilter-input';
    parent_selector = '.elfilter';
    input;
    parent;
    constructor() {
        this.input = document.querySelectorAll(this.input_selector);
        this.parent = document.querySelectorAll(this.parent_selector);
        for (const input of this.input) {
            input.addEventListener('keyup', () => {
                this.filter(input.value);
            }, false);
        }
    }
    filter(query) {
        query = query.toLowerCase();
        for (const parent of this.parent) {
            switch (parent.nodeName.toLowerCase()) {
                case 'ul':
                    for (const item of parent.querySelectorAll('li')) {
                        if (item.innerText.toLowerCase().indexOf(query) != -1) {
                            item.classList.remove('hide');
                        }
                        else {
                            item.classList.add('hide');
                        }
                    }
                    break;
                case 'table':
                    for (const tr of parent.querySelectorAll('tbody tr')) {
                        const result = [];
                        for (const td of tr.querySelectorAll('td')) {
                            result.push((td.innerText.toLowerCase().indexOf(query) == -1) ? 'hide' : 'show');
                        }
                        if (result.includes('show')) {
                            tr.classList.remove('hide');
                        }
                        else {
                            tr.classList.add('hide');
                        }
                    }
                    break;
            }
        }
        for (const input of this.input) {
            input.value = query;
        }
    }
}
