import { LazyMedia } from './lazymedia.js'
import { Scur } from './scur.js'
import { ImgZoom } from './imgzoom.js'
import { ElFilter } from './elfilter.js'




window.addEventListener('load', () => {
    new LazyMedia().autoembed()
    new Scur().autodeob()
    new ImgZoom().init()
    new ElFilter().init()

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
}, false)
