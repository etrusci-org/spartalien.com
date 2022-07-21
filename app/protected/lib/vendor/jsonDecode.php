<?php
declare(strict_types=1);


function jsonDecode(string $json, int $flags=JSON_THROW_ON_ERROR): array | null {
    return json_decode(json: $json, associative: true, depth: 512, flags: $flags);
}
