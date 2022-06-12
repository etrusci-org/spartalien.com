<?php
declare(strict_types=1);


/**
 * Convert HTML5 special characters to HTML entities.
 *
 * @param string $html  Input HTML.
 * @return string  Converted HTML.
 */
function hsc5(string $html): string {
    return htmlspecialchars($html, ENT_HTML5);
}
