import { Scur } from './vendor/scur.js'


export const App: AppInterface = {

    main() {
        console.log('%cSPARTALIEN.COM', 'font-size: 72px;')
        this.loadLazyMedia()
        Scur.deobElements()
    },

    loadLazyMedia() {
        let nodeList = document.querySelectorAll('[data-lazymedia]')
        if (nodeList instanceof NodeList) {
            nodeList.forEach(node => {
                if (
                    node instanceof HTMLElement &&
                    node.dataset['lazymedia'] !== undefined
                ) {
                    let mediaCode = node.dataset['lazymedia'].split(':')
                    let platform = mediaCode.slice(0, 1).join('')
                    let type     = mediaCode.slice(1, 2).join('')
                    let slug     = mediaCode.slice(2).join(':')

                    // youtube
                    if (platform == 'youtube') {
                        if (type == 'video') {
                            let embedEle = document.createElement('iframe')
                            embedEle.setAttribute('src', `//www.youtube.com/embed/${slug}?modestbranding=1&amp;color=white&amp;rel=0`)
                            embedEle.setAttribute('allowfullscreen', 'true')
                            node.replaceWith(embedEle)
                        }

                        if (type == 'playlist') {
                            let embedEle = document.createElement('iframe')
                            embedEle.setAttribute('src', `//www.youtube.com/embed/videoseries?list=${slug}&amp;modestbranding=1&amp;color=white&amp;rel=0`)
                            embedEle.setAttribute('allowfullscreen', 'true')
                            node.replaceWith(embedEle)
                        }
                    }

                    // bandcamp
                    if (platform == 'bandcamp') {
                        let embedEle = document.createElement('iframe')
                        embedEle.setAttribute('src', `//bandcamp.com/EmbeddedPlayer/${type}=${slug}/size=large/bgcol=ffffff/linkcol=0687f5/artwork=none/transparent=true/`)
                        node.replaceWith(embedEle)
                    }

                    // local
                    if (platform == 'generic') {
                        if (type == 'file') {
                            let embedEle = document.createElement('a')
                            embedEle.setAttribute('href', `file/${slug}`)
                            embedEle.innerHTML = slug
                            node.replaceWith(embedEle)
                        }

                        if (type == 'image') {
                            let embedEle = document.createElement('img')
                            embedEle.setAttribute('src', `file/${slug}`)
                            embedEle.setAttribute('alt', `${slug}`)
                            node.replaceWith(embedEle)
                        }

                        // TODO
                        // if (type == 'audio') {}
                        // if (type == 'video') {}
                    }

                }

            })
        }
    },
}
