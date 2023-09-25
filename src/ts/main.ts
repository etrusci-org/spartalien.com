import { LazyMedia } from './lazymedia.js'
import { Scur } from './scur.js'
import { ImgZoom } from './imgzoom.js'
import { ElFilter } from './elfilter.js'
import { VisitorProgress } from './visitorprogress.js'




window.addEventListener('load', () => {
    new LazyMedia().autoembed()
    new Scur().autodeob()
    new ImgZoom().init()
    new ElFilter().init()
    const VP = new VisitorProgress()

    document.querySelectorAll('a').forEach(element => {
        if (element.hostname && document.location.hostname != element.hostname) {
            element.setAttribute('target', '_blank')
            element.classList.add('external')
        }
    })

    document.querySelector('a.scroll_to_top')?.addEventListener('click', (event) => {
        event.preventDefault()
        window.scrollTo({top: 0, left: 0, behavior: 'smooth'})
    }, false)

    if (VP.opt_in && !document.location.pathname.endsWith('/play')) {
        VP.progress()
        console.log(VP.current_data)
    }
}, false)
