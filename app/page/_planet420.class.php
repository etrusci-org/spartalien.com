<?php
declare(strict_types=1);
namespace s9com;


class Page extends Core
{
    protected function get_session_list(): array
    {
        $dump = $this->DB->query('
            SELECT
                p420_session.num AS session_num,
                p420_session.pub_date AS session_pub_date,
                p420_session.runtime AS session_runtime,
                p420_session.mixcloud_key AS session_mixcloud_key,
                COUNT(p420_tracklist.session_num) AS session_track_count
            FROM p420_session
            LEFT JOIN p420_tracklist ON p420_tracklist.session_num = p420_session.num
            GROUP BY p420_session.num
            ORDER BY p420_session.num DESC;'
        );

        foreach ($dump as $k => $v) {
            $dump[$k]['session_runtime_human'] = $this->_seconds_to_dhms($v['session_runtime']);

            ksort($dump[$k]);
        }

        return $dump ?? [];
    }


    protected function get_session(int $session_num): array
    {
        $dump = $this->DB->query_single('
            SELECT
                p420_session.num AS session_num,
                p420_session.pub_date AS session_pub_date,
                p420_session.runtime AS session_runtime,
                p420_session.mixcloud_key AS session_mixcloud_key,
                COUNT(p420_tracklist.session_num) AS session_track_count
            FROM p420_session
            LEFT JOIN p420_tracklist ON p420_tracklist.session_num = p420_session.num
            WHERE p420_session.num = :session_num
            GROUP BY p420_session.num
            LIMIT 1;',
            [
                ['session_num', $session_num, SQLITE3_INTEGER],
            ]
        );

        $dump['session_runtime_human'] = $this->_seconds_to_dhms($dump['session_runtime']);
        $dump['session_track_list'] = $this->get_session_track_list($dump['session_num']);

        ksort($dump);

        return $dump ?? [];
    }


    protected function get_session_track_list(int $session_num): array
    {
        $dump = $this->DB->query('
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
            $dump[$k]['track_start_time_human'] = $this->_seconds_to_dhms($v['track_start_time']);

            ksort($dump[$k]);
        }

        return $dump ?? [];
    }


    protected function get_total_hours_to_listen(array $session_list): float
    {
        $s = array_sum(array_map(fn(array $v): int => $v['session_runtime'], $session_list));

        // Substract the first session runtime because the recording is lost
        $s -= $session_list[0]['session_runtime'];

        return floor($s / 3600);
    }
}
