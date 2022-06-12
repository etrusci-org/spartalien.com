/**
 * Get only the trailing name component of a path.
 *
 * @param {string} path  Path to parse.
 * @param {string} [sep='/']  Path separator.
 * @param {boolean} [ignoreTrailingSep=true]  Whether to ignore a trailing path separator.
 * @returns {string}  Trailing path name component.
 */
export function pathBasename(path: string, sep: string = '/', ignoreTrailingSep: boolean = true): string {
    if (ignoreTrailingSep && path.endsWith(sep)) {
        path = path.slice(0, -1)
    }
    return path.split(sep).pop() || path
}
