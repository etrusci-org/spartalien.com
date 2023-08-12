<?php
declare(strict_types=1);
namespace s9com;


class Page extends Core
{
    protected function get_rls_list(?array $rls_ids = null): array
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
        $dump['track_list'] = $this->get_rls_tracklist($dump['id']);
        $dump['track_count'] = count($dump['track_list']);
        $dump['media'] = $this->get_rls_media($dump['id']);
        $dump['credit'] = $this->get_rls_credit($dump['id']);
        $dump['dist'] = $this->get_rls_dist($dump['id']);

        return $dump ?? [];
    }


    protected function get_rls_tracklist(int $rls_id): array
    {
        $dump = $this->DB->query('
            SELECT
                rls_tracklist.track_id,
                track.name,
                track.runtime,
                artist.id AS artist_id,
                artist.name AS artist
            FROM rls_tracklist
            LEFT JOIN track ON track.id = rls_tracklist.track_id
            LEFT JOIN artist ON artist.id = track.artist_id
            WHERE rls_id = :rls_id
            ORDER BY rls_tracklist.track_id ASC;
            ',
            [
                ['rls_id', $rls_id, SQLITE3_INTEGER],
            ]
        );

        foreach ($dump as $k => $v) {
            $dump[$k]['credit'] = $this->get_track_credit($v['track_id']);
            $dump[$k]['dist'] = $this->get_track_dist($v['track_id']);
        }

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


    protected function get_track_list(?array $track_ids = null): array
    {
        // $where = '';
        // if ($track_ids) {
        //     $where = 'WHERE id IN ('.implode(', ', $track_ids).')';
        // }

        $dump = $this->DB->query('
            SELECT
                track.id,
                track.name,
                track.runtime,
                track.bandcamp_id,
                artist.name AS artist_name
            FROM track
            LEFT JOIN artist ON artist.id = track.artist_id
            ORDER BY LOWER(track.name) ASC;',
        );

        foreach ($dump as $k => $v) {
            $dump[$k]['dist'] = $this->get_track_dist($v['id']);
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
        $dump = [];

        foreach ($dist as $v) {
            $dump[] = '<a href="'.$v['url'].'" target="_blank">'.ucwords($v['platform']).'</a>';
        }

        return $dump;
    }










        // protected function get_rls_list(): array
        // {
        //     return $this->DB->query('
        //         SELECT
        //             rls.id,
        //             rls.artist,
        //             rls.name,
        //             rls.track_ids,
        //             JSON_ARRAY_LENGTH(rls.track_ids) AS track_count,
        //             rls_type.name AS type,
        //             rls.pub_date,
        //             rls.upd_date,
        //             rls.is_freedl,
        //             CASE
        //                 WHEN rls.upd_date IS NULL
        //                     THEN rls.pub_date
        //                     ELSE rls.upd_date
        //                 END list_order
        //         FROM rls
        //         LEFT JOIN rls_type ON rls_type.id = rls.type_id
        //         ORDER BY list_order DESC, rls.id DESC;
        //     ');
        // }


    // protected function get_rls(int $rls_id): array
    // {
    //     $rls = $this->DB->query_single('
    //         SELECT
    //             rls.id,
    //             rls.artist,
    //             rls.name,
    //             rls.track_ids,
    //             JSON_ARRAY_LENGTH(rls.track_ids) AS track_count,
    //             rls_type.name AS type,
    //             rls.pub_date,
    //             rls.upd_date,
    //             rls.description,
    //             rls.credits,
    //             rls.thanks,
    //             rls.media,
    //             rls.is_freedl,
    //             distinfo.platforms
    //         FROM rls
    //         LEFT JOIN rls_type ON rls_type.id = rls.type_id
    //         LEFT JOIN distinfo ON distinfo.rls_id = rls.id
    //         WHERE rls.id = :id
    //         LIMIT 1;',
    //         [
    //             ['id', $rls_id, SQLITE3_INTEGER],
    //         ]
    //     );

    //     $rls['track_ids'] = $this->_json_dec($rls['track_ids']);
    //     $rls['credits'] = $this->_json_dec($rls['credits']);
    //     $rls['thanks'] = $this->_json_dec($rls['thanks']);
    //     $rls['media'] = $this->_json_dec($rls['media']);
    //     $rls['platforms'] = $this->_json_dec($rls['platforms']);
    //     $dump = $this->get_track_list($rls['track_ids']);
    //     $rls['track_list'] = $dump['track_list'];
    //     $rls['total_runtime'] = $dump['total_runtime'];

    //     return $rls;
    // }


        // protected function get_track_list(?array $track_ids = null): array
        // {
        //     $where = '';
        //     if ($track_ids) {
        //         $where = 'WHERE id IN ('.implode(', ', $track_ids).')';
        //     }

        //     $dump = $this->DB->query('
        //         SELECT
        //             track.id,
        //             track.artist,
        //             track.name,
        //             track.runtime,
        //             distinfo.platforms
        //         FROM track
        //         LEFT JOIN distinfo ON distinfo.track_id = track.id
        //         '.$where.'
        //         ORDER BY track.id DESC;',
        //     );

        //     $track_list = [];
        //     $total_runtime = 0;

        //     foreach ($dump as $v) {
        //         $v['platforms'] = $this->_json_dec($v['platforms']);

        //         $track_list[] = $v;
        //         $total_runtime += $v['runtime'];
        //     }

        //     return [
        //         'track_list' => $track_list,
        //         'total_runtime' => $total_runtime,
        //     ];
        // }


    // protected function get_track(int $track_id): array
    // {
    //     $dump = $this->get_track_list([$track_id]);
    //     return $dump['track_list'][0];
    // }


        // protected function bake_platform_links(array $platforms): array
        // {
        //     $dump = [];
        //     foreach ($platforms as $v) {
        //         $dump[] = '<a href="'.$v['url'].'" target="_blank">'.$v['name'].'</a>';
        //     }
        //     return $dump;
        // }
}
