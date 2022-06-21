export function addTargetToExtLinks(localHostnames, target = '_blank') {
    let anchors = document.querySelectorAll('a');
    anchors.forEach(e => {
        if (localHostnames.indexOf(e.hostname) == -1 && e.protocol != 'mailto:') {
            e.setAttribute('target', target);
        }
    });
}
