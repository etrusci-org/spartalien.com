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
                p420_session.mixcloud_url AS session_mixcloud_url,
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
                p420_session.mixcloud_url AS session_mixcloud_url,
                COUNT(p420_tracklist.session_num) AS session_track_count
            FROM p420_session
            LEFT JOIN p420_tracklist ON p420_tracklist.session_num = p420_session.num
            WHERE p420_session.num = :session_num
            GROUP BY p420_session.num
            ORDER BY p420_session.num DESC;',
            [
                ['session_num', $session_num, SQLITE3_INTEGER],
            ]
        );

        $dump['session_runtime_human'] = $this->_seconds_to_dhms($dump['session_runtime']);
        $dump['session_track_list'] = $this->get_tracklist($dump['session_num']);

        ksort($dump);

        return $dump ?? [];
    }


    protected function get_tracklist(int $session_num): array
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

        return $dump ?? [];
    }
}
