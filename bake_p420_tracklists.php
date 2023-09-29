#!/usr/bin/env php
<?php
declare(strict_types=1);
namespace s9com;


$APP_DIR = realpath(__DIR__.'/app');
$OUT_DIR = realpath('../spartalien.com-files/file/planet420');


if (!$OUT_DIR) die('OUT_DIR does not exist');
// print('OUT_DIR: '.$OUT_DIR.PHP_EOL);


// ----------------------------------------------------------------------------


$TEMPLATE = '
Planet 420.{session_num} / {session_pub_date}

Runtime: {session_runtime_human}
@Home: https://spartalien.com/planet420/session:{session_num}
@Mixcloud: {session_mixcloud_url}

{session_tracklist}
';


require $APP_DIR.'/conf.php';
require $APP_DIR.'/lib/database.php';


function get_session_list(Database $DB): array
{
    $dump = $DB->query('
        SELECT
            p420_session.num AS session_num,
            p420_session.pub_date AS session_pub_date,
            p420_session.runtime AS session_runtime,
            p420_session.mixcloud_key AS session_mixcloud_key,
            COUNT(p420_tracklist.session_num) AS session_track_count
        FROM p420_session
        LEFT JOIN p420_tracklist ON p420_tracklist.session_num = p420_session.num
        GROUP BY p420_session.num
        ORDER BY p420_session.num ASC;'
    );

    foreach ($dump as $k => $v) {
        $dump[$k]['session_runtime_human'] = seconds_to_dhms($v['session_runtime']);
        $dump[$k]['session_tracklist'] = get_session_tracklist($DB, $v['session_num']);
    }

    return $dump;
}


function get_session_tracklist(Database $DB, int $session_num): array
{
    $dump = $DB->query('
        SELECT
            p420_tracklist.start_time AS track_start_time,
            p420_tracklist.artist AS artist_name,
            p420_tracklist.track AS track_name
        FROM p420_tracklist
        WHERE p420_tracklist.session_num = :session_num
        ORDER BY p420_tracklist.start_time ASC;',
        [
            ['session_num', $session_num, SQLITE3_INTEGER],
        ]
    );

    foreach ($dump as $k => $v) {
        $dump[$k]['track_start_time_human'] = seconds_to_dhms($v['track_start_time']);
    }

    return $dump ?? [];
}


function seconds_to_dhms(int $seconds): string
{
    $s = max(0, $seconds);

    $dur = [
        'd' => floor($s / (3600 * 24)),
        'h' => floor($s % (3600 * 24) / 3600),
        'm' => floor($s % 3600 / 60),
        's' => floor($s % 60),
    ];

    if ($dur['d'] > 0) {
        return sprintf('%d:%02d:%02d:%02d', $dur['d'], $dur['h'], $dur['m'], $dur['s']);
    }

    if ($dur['h'] > 0) {
        return sprintf('%d:%02d:%02d', $dur['h'], $dur['m'], $dur['s']);
    }

    return sprintf('%d:%02d', $dur['m'], $dur['s']);
}


// ----------------------------------------------------------------------------


$DB = new Database($conf['db_file']);
$DB->open(rw: false);

$session_list = get_session_list($DB);
// print_r($session_list);


// ----------------------------------------------------------------------------


foreach ($session_list as $s) {

    $out_file = $OUT_DIR.'/planet420-'.$s['session_num'].'-'.str_replace('-', '', $s['session_pub_date']).'.txt';

    if (file_exists($out_file)) continue;

    $txt = trim($TEMPLATE);

    $tracklist = [];
    foreach ($s['session_tracklist'] as $v) {
        $tracklist[] = $v['track_start_time_human'].' '.$v['artist_name'].' - '.$v['track_name'];
    }
    $tracklist = implode("\n", $tracklist);

    $txt = strtr($txt, [
        '{session_num}' => $s['session_num'],
        '{session_pub_date}' => $s['session_pub_date'],
        '{session_runtime_human}' => $s['session_runtime_human'],
        '{session_mixcloud_url}' => ($s['session_mixcloud_key']) ? 'https://mixcloud.com/'.$s['session_mixcloud_key'].'/' : 'Sorry, this recording is lost.',
        '{session_tracklist}' => $tracklist,
    ]);

    $txt = implode("\n", array_map(fn(string $v) => trim($v), explode(PHP_EOL, $txt)));

    // print('creating '.$out_file.PHP_EOL);
    file_put_contents($out_file, $txt, LOCK_EX);
}


print(microtime(true).' baked p420 tracklists ('.array_sum(array_map(function(string $v): int { return filesize($v); }, glob($OUT_DIR.'/planet420-*.txt'))).' bytes)'.PHP_EOL);
