<?php
require __DIR__.'/../conf.php';
require_once __DIR__.'/../lib/vendor/jsonEncode.php';

$validRequests = array();

printf('parsing %d route patterns...'.PHP_EOL, count($conf['validRequestPatterns']));

$scriptStart = microtime(TRUE);

foreach ($conf['validRequestPatterns'] as $requestPattern) {
    // ignore intelephense(1006) on $requestPattern of preg_match, it's a bug in intelephense.

    // range :[n-n]
    // e.g. news/id:[1-123]
    if (preg_match('/(.+:)\[(\d+)-(\d+)\]/i', $requestPattern, $patternMatch)) {
        foreach (range($patternMatch[2], $patternMatch[3]) as $v) {
            $validRequests[] = sprintf('\'%1$s%2$s\'', $patternMatch[1], $v);
        }
    }
    // or :[a|b]
    // e.g. news/foo:a or news/foo:b
    else if (preg_match('/(.+:)\[([\w|]+)\]/i', $requestPattern, $patternMatch)) {
        foreach (explode('|', $patternMatch[2]) as $v) {
            $validRequests[] = sprintf('\'%1$s%2$s\'', $patternMatch[1], $v);
        }
    }
    // default as-is
    // e.g. news/foo/bar/moo:cow
    else {
        $validRequests[] = sprintf('\'%1$s\'', $requestPattern);
    }
}

printf('baked %d valid request strings...'.PHP_EOL, count($validRequests));

$validRequests = sprintf('<?php define(\'VALID_REQUESTS\', array(%1$s)); ?>'.PHP_EOL, implode(',', $validRequests));

file_put_contents(__DIR__.'/../cache/validrequests.php', $validRequests);

printf('done in %f seconds'.PHP_EOL, (microtime(TRUE) - $scriptStart));
