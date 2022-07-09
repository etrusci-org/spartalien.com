import { randomQuotes } from './randomQuotes.js';
export const RandomQuoteTyper = {
    quotes: randomQuotes,
    typingSpeed: 120,
    target: document.querySelector('.randomQuoteTyperTarget'),
    quote: null,
    typerID: null,
    typeQuote() {
        if (!this.target || this.typerID)
            return;
        this.quote = this.getRandomQuote();
        if (!this.quote)
            return;
        let dump = `"${this.quote['quote']}" — ${this.quote['author']}`.split('');
        this.target.innerHTML = ``;
        this.typerID = setInterval(() => {
            if (!this.target)
                return;
            this.target.innerHTML += `${dump.shift()}`;
            if (dump.length == 0)
                this.stop();
        }, this.typingSpeed);
    },
    getRandomQuote() {
        return randomQuotes[Math.floor(Math.random() * randomQuotes.length)] || null;
    },
    stop() {
        if (!this.typerID || !this.target)
            return;
        clearInterval(this.typerID);
        this.typerID = null;
    },
};
