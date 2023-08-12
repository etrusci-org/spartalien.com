#!/usr/bin/env php
<?php
declare(strict_types=1);
namespace s9com;


$APP_DIR = realpath(__DIR__.'/app');


require $APP_DIR.'/conf.php';
require $APP_DIR.'/lib/database.php';


$DB = new Database($conf['db_file']);
$DB->open(rw: false);


$valid_requests_file = $conf['valid_requests_file'];
$valid_request_patterns = $conf['valid_request_patterns'];


$valid_requests = [];
$replacements = [];

foreach ($valid_request_patterns as $pattern) {
    // for routes without values just add the route pattern
    if (!$pattern['valuesTable']) {
        $valid_requests[] = $pattern['route'];
    }
    // for routes with values get the possible values
    else {
        // find values placeholders in route pattern
        if (!preg_match_all('/{([\w]+)}/', $pattern['route'], $pattern_matches)) {
            continue;
        }

        foreach ($pattern_matches[0] as $valueKey => $value) {
            $r = $DB->query('
                SELECT DISTINCT '.$pattern['valuesCol'][$pattern_matches[1][$valueKey]].' AS value
                FROM '.$pattern['valuesTable'].'
                WHERE '.$pattern['valuesCol'][$pattern_matches[1][$valueKey]].' IS NOT NULL
                ORDER BY '.$pattern['valuesCol'][$pattern_matches[1][$valueKey]].' COLLATE NOCASE ASC;
            ');

            $p = [];
            foreach ($r as $v) {
                $p[] = $v['value'];
            }
            $p = '\b('.implode('|', $p).')\b';

            $replacements[$value] = $p;
        }

        $valid_requests[] = strtolower(strtr($pattern['route'], $replacements));
    }
}

$dump = [];
foreach ($valid_requests as $v) {
    $dump[] = "'".$v."'";
}
$dump = sprintf('<?php $valid_requests = [%s]; ?>'.PHP_EOL, implode(', ', $dump));

file_put_contents($valid_requests_file, $dump, LOCK_EX);

print(microtime(true).' baked valid requests ('.filesize($conf['valid_requests_file']).' bytes)'.PHP_EOL);
