export function scroll_to_top(): void
{
    window.scrollTo({ top: 0, left: 0, behavior: 'smooth' })
}



export function add_anchor_target_to_external_links(target: string = '_blank'): void
{
    document.querySelectorAll('a').forEach(e => {
        if (e.hostname && document.location.hostname != e.hostname) {
            e.setAttribute('target', target)
            e.classList.add('external')
        }
    })
}
