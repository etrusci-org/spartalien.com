<?php
declare(strict_types=1);


/**
 * Convert HTML5 special characters to HTML entities.
 *
 * @param string $html  Input HTML.
 * @return string  Converted HTML.
 *
 * @example hsc5.example.php
 * @see https://php.net/htmlspecialchars
 */
function hsc5(string $html): string {
    return htmlspecialchars($html, ENT_HTML5);
}
