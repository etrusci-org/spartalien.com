import { Scur } from './vendor/scur.js'


export const App: AppInterface = {

    main() {
        console.log('SPARTALIEN.COM')
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
                    let platform  = mediaCode.slice(0, 1).join('')
                    let type      = mediaCode.slice(1, 2).join('')
                    let slug      = mediaCode.slice(2).join(':')

                    if (platform == 'youtube') {
                        if (type == 'video') {
                            let embedEle = document.createElement('iframe')
                            embedEle.setAttribute('src', `//www.youtube.com/embed/${slug}?modestbranding=1&color=white&rel=0`)
                            embedEle.setAttribute('allowfullscreen', 'true')
                            node.replaceWith(embedEle)
                        }

                        if (type == 'playlist') {
                            let embedEle = document.createElement('iframe')
                            embedEle.setAttribute('src', `//www.youtube.com/embed/videoseries?list=${slug}&modestbranding=1&color=white&rel=0`)
                            embedEle.setAttribute('allowfullscreen', 'true')
                            node.replaceWith(embedEle)
                        }
                    }

                    if (platform == 'bandcamp') {
                        let embedEle = document.createElement('iframe')
                        embedEle.setAttribute('src', `//bandcamp.com/EmbeddedPlayer/${type}=${slug}/size=large/bgcol=ffffff/linkcol=0687f5/artwork=none/transparent=true/`)
                        node.replaceWith(embedEle)
                    }

                    if (platform == 'mixcloud') {
                        let embedEle = document.createElement('iframe')

                        if (type == 'mix') {
                            embedEle.setAttribute('src', `//www.mixcloud.com/widget/iframe/?hide_cover=1&feed=${slug}`)
                            embedEle.classList.add('mixcloud', 'mix')
                            node.replaceWith(embedEle)
                        }

                        if (type == 'playlist') {
                            embedEle.setAttribute('src', `//www.mixcloud.com/widget/iframe/?hide_cover=1&feed=${slug}`)
                            embedEle.classList.add('mixcloud', 'playlist')
                            node.replaceWith(embedEle)
                        }
                    }

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
