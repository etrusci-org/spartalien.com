<?php
declare(strict_types=1);
namespace s9com;


class Page extends Core
{
    protected function get_track_list(?int $rls_id = null): array
    {
        $where = '';
        $order = 'ORDER BY LOWER(track.name) ASC;';
        if ($rls_id) {
            $where = 'WHERE rls_id = :rls_id';
            $order = 'ORDER BY rls_tracklist.track_id ASC';
        }

        $dump = $this->DB->query('
            SELECT
                DISTINCT rls_tracklist.track_id,
                track.name,
                track.runtime,
                artist.id AS artist_id,
                artist.name AS artist
            FROM rls_tracklist
            LEFT JOIN track ON track.id = rls_tracklist.track_id
            LEFT JOIN artist ON artist.id = track.artist_id
            '.$where.'
            '.$order.';',
            [
                ['rls_id', $rls_id, SQLITE3_INTEGER],
            ]
        );

        foreach ($dump as $k => $v) {
            $dump[$k]['runtime_human'] = $this->_seconds_to_dhms($v['runtime']);
            $dump[$k]['credit'] = $this->get_track_credit($v['track_id']);
            $dump[$k]['dist'] = $this->get_track_dist($v['track_id']);
            $dump[$k]['dist_links'] = $this->bake_dist_links($dump[$k]['dist']);
        }

        return $dump ?? [];
    }


    protected function get_track_credit(int $track_id): array
    {
        $dump = $this->DB->query('
            SELECT
                track_credit.line
            FROM track_credit
            WHERE track_id = :track_id;
            ',
            [
                ['track_id', $track_id, SQLITE3_INTEGER],
            ]
        );

        $dump = array_map(function(array $v): string {
            return $v['line'];
        }, $dump);

        return $dump ?? [];
    }


    protected function get_track_dist(int $track_id): array
    {
        $dump = $this->DB->query('
            SELECT
                platform,
                url
            FROM track_dist
            WHERE track_id = :track_id
            ORDER BY platform ASC;',
            [
                ['track_id', $track_id, SQLITE3_INTEGER],
            ],
        );

        return $dump ?? [];
    }


    protected function get_rls_list(/*?array $rls_ids = null*/): array
    {
        // $where = '';
        // if ($rls_ids) {
        //     $where = 'WHERE id IN ('.implode(', ', $rls_ids).')';
        // }

        $dump = $this->DB->query('
            SELECT
                rls.id,
                rls.name,
                CASE
                    WHEN rls.upd_date IS NULL
                        THEN rls.pub_date
                        ELSE rls.upd_date
                END list_order
            FROM rls
            ORDER BY list_order DESC;',
        );

        foreach ($dump as $k => $v) {
            $dump[$k]['coverart_file'] = $this->get_rls_coverart_file_path($v['id']);
        }

        return $dump ?? [];
    }


    protected function get_rls(int $rls_id): array
    {
        $dump = $this->DB->query_single('
            SELECT
                rls.id,
                rls.name,
                rls.pub_date,
                rls.upd_date,
                rls.description,
                rls.is_freedl,
                rls.bandcamp_id,
                artist.name AS artist,
                rls_type.name AS type,
                label.name AS label
            FROM rls
            LEFT JOIN artist ON artist.id = rls.artist_id
            LEFT JOIN rls_type ON rls_type.id = rls.rls_type_id
            LEFT JOIN label ON label.id = rls.label_id
            WHERE rls.id = :rls_id;',
            [
                ['rls_id', $rls_id, SQLITE3_INTEGER],
            ]
        );

        $dump['coverart_file'] = $this->get_rls_coverart_file_path($dump['id']);
        $dump['track_list'] = $this->get_track_list($dump['id']);
        $dump['track_count'] = count($dump['track_list']);
        $dump['media'] = $this->get_rls_media($dump['id']);
        $dump['credit'] = $this->get_rls_credit($dump['id']);
        $dump['dist'] = $this->get_rls_dist($dump['id']);
        $dump['dist_links'] = $this->bake_dist_links($dump['dist']);

        return $dump ?? [];
    }


    protected function get_rls_credit(int $rls_id): array
    {
        $dump = $this->DB->query('
            SELECT
                rls_credit.line
            FROM rls_credit
            WHERE rls_id = :rls_id;
            ',
            [
                ['rls_id', $rls_id, SQLITE3_INTEGER],
            ]
        );

        $dump = array_map(function(array $v): string {
            return $v['line'];
        }, $dump);

        return $dump ?? [];
    }


    protected function get_rls_media(int $rls_id): array
    {
        $dump = $this->DB->query('
            SELECT
                rls_media.code
            FROM rls_media
            WHERE rls_id = :rls_id;
            ',
            [
                ['rls_id', $rls_id, SQLITE3_INTEGER],
            ]
        );

        $dump = array_map(function(array $v): string {
            return $v['code'];
        }, $dump);

        return $dump ?? [];
    }


    protected function get_rls_coverart_file_path(int $rls_id): array
    {
        return [
            'tn' => './file/cover/'.$rls_id.'-tn.jpg',
            'med' => './file/cover/'.$rls_id.'-med.jpg',
            'big' => './file/cover/'.$rls_id.'-big.png',
        ];
    }


    protected function get_rls_dist(int $rls_id): array
    {
        $dump = $this->DB->query('
            SELECT
                rls_id,
                platform,
                url
            FROM rls_dist
            WHERE rls_id = :rls_id
            ORDER BY platform ASC;',
            [
                ['rls_id', $rls_id, SQLITE3_INTEGER],
            ],
        );

        return $dump ?? [];
    }


    protected function bake_dist_links(array $dist): array
    {
        return array_map(function(array $v) {
            return '<a href="'.$v['url'].'" target="_blank">'.ucwords($v['platform']).'</a>';
        }, $dist) ?? [];
    }
}
