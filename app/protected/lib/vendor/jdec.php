<?php
declare(strict_types=1);


/**
 * Convert JSON to an associative array.
 *
 * @param string|null $data  Input JSON.
 * @param int $depth=512  Maximum nesting depth of the structure being decoded.
 * @param int $flags=JSON_THROW_ON_ERROR  JSON options bitmask.
 * @return array|bool Converted data or false.
 */
function jdec(string|null $data, int $depth = 512, int $flags=JSON_THROW_ON_ERROR): array|bool {
    if (!$data) return false;
    return json_decode(json: $data, associative: true, depth: $depth, flags: $flags);
}
