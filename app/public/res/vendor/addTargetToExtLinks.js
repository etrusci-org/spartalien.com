export function addTargetToExtLinks(target = '_blank', cssClass = '') {
    let anchors = document.querySelectorAll('a');
    anchors.forEach(e => {
        if (e.hostname && document.location.hostname != e.hostname) {
            e.setAttribute('target', target);
            e.setAttribute('rel', 'nofollow');
            if (cssClass) {
                e.classList.add(cssClass);
            }
        }
    });
}
