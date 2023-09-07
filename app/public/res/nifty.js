export function scroll_to_top() {
    window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
}
export function add_anchor_target_to_external_links(target = '_blank') {
    document.querySelectorAll('a').forEach(e => {
        if (e.hostname && document.location.hostname != e.hostname) {
            e.setAttribute('target', target);
        }
    });
}
