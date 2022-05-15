<?php
declare(strict_types=1);


/**
 * Convert JSON to an associative array.
 *
 * @param string|null $data  Input JSON.
 * @return array|null  Converted data or null.
 *
 * @example jdec.example.php
 * @see https://php.net/json_decode
 */
function jdec(string|null $data): array|null {
    if (!$data) return null;
    return json_decode($data, TRUE);
}
