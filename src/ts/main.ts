import { App } from './app.js'


window.addEventListener('load', () => {
    // @ts-ignore: routeRequest set in app/protected/page/_footer.php
    App.main(routeRequest)
}, false)
