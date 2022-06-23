export function addTargetToExtLinks(target = '_blank') {
    let anchors = document.querySelectorAll('a');
    anchors.forEach(e => {
        if (document.location.hostname != e.hostname) {
            e.setAttribute('target', target);
        }
    });
}
