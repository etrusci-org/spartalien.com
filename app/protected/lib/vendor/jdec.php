<?php
/**
 * Convert JSON to an associative array.
 *
 * @param string $data  Input JSON.
 * @return array|null  Converted data or null.
 *
 * @example jdec.example.php
 * @see https://php.net/json_decode
 */
function jdec(string $data): array|null {
    return json_decode($data, TRUE);
}
