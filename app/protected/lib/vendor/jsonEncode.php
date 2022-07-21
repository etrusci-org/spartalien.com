<?php
declare(strict_types=1);


function jsonEncode(mixed $value, int $flags=JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT): string | false {
    return json_encode(value: $value, flags: $flags, depth: 512);
}
