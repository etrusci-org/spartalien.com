<?php
require __DIR__.'/../conf.php';
require_once __DIR__.'/../lib/vendor/jenc.php';

$validRequests = array(
    '<?php',
    sprintf('# last update: %1$s', date('Y-m-d H:i:s T')),
    'define(\'VALID_REQUESTS\', array(',
);

printf('parsing %d route patterns...'.PHP_EOL, count($conf['validRequestPatterns']));

$scriptStart = microtime(TRUE);

foreach ($conf['validRequestPatterns'] as $requestPattern) {
    // ignore intelephense(1006) on $requestPattern of preg_match, it's a bug in intelephense.

    // range :[n-n]
    if (preg_match('/(.+:)\[(\d+)-(\d+)\]/i', $requestPattern, $patternMatch)) {
        foreach (range($patternMatch[2], $patternMatch[3]) as $v) {
            $validRequests[] = sprintf('    \'%1$s%2$s\',', $patternMatch[1], $v);
        }
    }
    // or :[a|b]
    else if (preg_match('/(.+:)\[([\w|]+)\]/i', $requestPattern, $patternMatch)) {
        foreach (explode('|', $patternMatch[2]) as $v) {
            $validRequests[] = sprintf('    \'%1$s%2$s\',', $patternMatch[1], $v);
        }
    }
    // default as-is
    else {
        $validRequests[] = sprintf('    \'%1$s\',', $requestPattern);
    }
}

$validRequests[] = '));';
$validRequests[] = '?>';

file_put_contents(__DIR__.'/../cache/validrequests.php', implode(PHP_EOL, $validRequests));

printf('done in %f seconds'.PHP_EOL, (microtime(TRUE) - $scriptStart));
