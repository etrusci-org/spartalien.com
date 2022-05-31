<?php
declare(strict_types=1);


/**
 * Convert data to JSON.
 *
 * @param mixed $data   Input data.
 * @param int   $flags  JSON options bitmask.
 * @return string|bool  Converted data or false.
 *
 * @example jenc.example.php
 * @see https://php.net/json_encode
 * @see https://php.net/manual/json.constants.php
 */
function jenc(mixed $data, int $flags=JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT): string|bool {
    if (!$data) return false;
    return json_encode($data, $flags);
}
