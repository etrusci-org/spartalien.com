export function addTargetToExtLinks(target = '_blank', cssClass = 'external-link') {
    let anchors = document.querySelectorAll('a');
    anchors.forEach(e => {
        if (e.hostname && document.location.hostname != e.hostname) {
            e.setAttribute('target', target);
            if (cssClass) {
                e.classList.add(cssClass);
            }
        }
    });
}
