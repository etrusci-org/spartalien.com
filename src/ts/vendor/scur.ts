export const Scur: ScurInterface = {
    s: 'change_me',
    ob(data) {
        return this._r(btoa(this._r(data) + this.s))
    },
    deob(data) {
        return this._r(atob(this._r(data)).replace(this.s, ''))
    },
    _r(data) {
        return data.split('').reverse().join('')
    },
}
