<?php
declare(strict_types=1);


/**
 * Convert data to JSON.
 *
 * @param mixed $data  Input data.
 * @param int $flags=JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT  JSON options bitmask.
 * @param int $depth=512  Maximum depth. Must be greater than zero.
 * @return string|bool  Converted data or false.
 */
function jenc(mixed $data, int $flags=JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT, int $depth=512): string|bool {
    if (!$data) return false;
    return json_encode(value: $data, flags: $flags, depth: $depth);
}
