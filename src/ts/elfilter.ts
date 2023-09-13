export class ElFilter
{
    public input_selector: string = 'input.elfilter-input'
    public parent_selector: string = '.elfilter'

    private input: NodeListOf<HTMLInputElement>
    private parent: NodeListOf<HTMLElement>


    constructor()
    {
        // Get all input elements
        this.input = document.querySelectorAll(this.input_selector)

        // Get all parent elements
        this.parent = document.querySelectorAll(this.parent_selector)

        // Register event listener on keyup for every input element
        for (const input of this.input) {
            input.addEventListener('keyup', () => {
                this.filter(input.value)
            }, false)
        }
    }


    private filter(query: string): void
    {
        // Prepare query string for usage
        query = query.toLowerCase()

        // Loop tru parent elements
        for (const parent of this.parent) {
            // Process parent elements depending on their type
            switch (parent.nodeName.toLowerCase())
            {
                // Process <ul>'s
                case 'ul':
                    // Loop tru <li>'s
                    for (const item of parent.querySelectorAll('li')) {
                        // Show <li> if matched
                        if (item.innerText.toLowerCase().indexOf(query) != -1) {
                            item.classList.remove('hide')
                        }
                        // Show <li> if no match
                        else {
                            item.classList.add('hide')
                        }
                    }
                break

                // Process <table>'s
                case 'table':
                    // Loop tru <tr>'s
                    for (const tr of parent.querySelectorAll('tbody tr')) {
                        // Collect match results from <td>'s
                        const result = []
                        for (const td of tr.querySelectorAll('td')) {
                            result.push((td.innerText.toLowerCase().indexOf(query) == -1) ? 'hide' : 'show')
                        }

                        // Show <tr> if at least one <td> matched
                        if (result.includes('show')) {
                            tr.classList.remove('hide')
                        }
                        // Hide <tr> if at no <td> matched
                        else {
                            tr.classList.add('hide')
                        }
                    }
                break
            }
        }

        // Update all filter input values
        for (const input of this.input) {
            input.value = query
        }
    }
}
