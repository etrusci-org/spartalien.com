import { App } from './app.js'


window.addEventListener('load', () => {
    // @ts-ignore: routeRequest set in app/protected/page/_footer.php
    // FIXME: since this works only when javascript is enabled, we could also fetch the path from the document url with javascript.
    App.main(routeRequest)
}, false)
