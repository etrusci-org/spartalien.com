export function pathBasename(path, sep = '/', ignoreTrailingSep = true) {
    if (ignoreTrailingSep && path.endsWith(sep)) {
        path = path.slice(0, -1);
    }
    return path.split(sep).pop() || path;
}
