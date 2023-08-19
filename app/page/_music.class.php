<?php
declare(strict_types=1);
namespace s9com;


class Page extends Core
{
    protected function get_artist(int $artist_id): array
    {
        $dump = $this->DB->query_single('
            SELECT
                artist.id AS artist_id,
                artist.name AS artist_name,
                artist.description AS artist_description,
                artist.url AS artist_url
            FROM artist
            WHERE artist.id = :artist_id
            LIMIT 1;',
            [
                ['artist_id', $artist_id, SQLITE3_INTEGER],
            ]
        );

        return $dump ?? [];
    }


    protected function get_catalog_track_list(): array
    {
        $dump = $this->DB->query('
            SELECT
                track.id AS track_id,
                track.name AS track_name,
                track.runtime AS track_runtime,
                artist.id AS artist_id,
                artist.name AS artist_name
            FROM track
            LEFT JOIN artist ON artist.id = track.artist_id
            ORDER BY LOWER(track.name) ASC;'
        );

        foreach ($dump as $k => $v) {
            $dump[$k]['track_runtime_human'] = $this->_seconds_to_dhms($dump[$k]['track_runtime']);

            ksort($dump[$k]);
        }

        return $dump ?? [];
    }


    protected function get_rls_track_list(int $rls_id): array
    {
        $where = '';
        $order = 'ORDER BY track.name ASC;';
        if ($rls_id) {
            $where = 'WHERE rls_id = :rls_id';
            $order = 'ORDER BY track.id ASC';
        }

        $track_order = 1;

        $dump = $this->DB->query('
            SELECT
                DISTINCT track.id AS track_id,
                track.name AS track_name,
                track.runtime AS track_runtime,
                artist.id AS artist_id,
                artist.name AS artist_name
            FROM rls_tracklist
            LEFT JOIN track ON track.id = rls_tracklist.track_id
            LEFT JOIN artist ON artist.id = track.artist_id
            '.$where.'
            '.$order.';',
            [
                ['rls_id', $rls_id, SQLITE3_INTEGER],
            ]
        );

        $track_order = 1;
        foreach ($dump as $k => $v) {
            $dump[$k]['track_runtime_human'] = $this->_seconds_to_dhms($v['track_runtime']);
            if ($rls_id) {
                $dump[$k]['track_order'] = $track_order++;
                $dump[$k]['track_credit'] = $this->get_credit('track', $dump[$k]['track_id']);
                $dump[$k]['track_dist'] = $this->get_dist('track', $dump[$k]['track_id']);
                $dump[$k]['track_dist_link'] = $this->bake_dist_links($dump[$k]['track_dist']);
            }

            ksort($dump[$k]);
        }

        return $dump ?? [];
    }


    protected function get_rls_list(): array
    {
        $dump = $this->DB->query('
            SELECT
                rls.id AS rls_id,
                rls.name AS rls_name,
                CASE
                    WHEN rls.upd_date IS NULL
                        THEN rls.pub_date
                        ELSE rls.upd_date
                END rls_list_order
            FROM rls
            ORDER BY rls_list_order DESC;',
        );

        foreach ($dump as $k => $v) {
            $dump[$k]['rls_coverart_file'] = $this->get_rls_coverart_file_path($v['rls_id']);
        }

        return $dump ?? [];
    }


    protected function get_track(int $track_id): array
    {
        $dump = $this->DB->query_single('
            SELECT
                DISTINCT track.id AS track_id,
                track.name AS track_name,
                track.runtime AS track_runtime,
                track.bandcamp_id AS track_bandcamp_id,
                artist.id AS artist_id
            FROM rls_tracklist
            LEFT JOIN track ON track.id = rls_tracklist.track_id
            LEFT JOIN artist ON artist.id = track.artist_id
            WHERE track.id = :track_id
            LIMIT 1;',
            [
                ['track_id', $track_id, SQLITE3_INTEGER],
            ]
        );


        $dump['track_runtime_human'] = $this->_seconds_to_dhms($dump['track_runtime']);
        $dump['track_credit'] = $this->get_credit('track', $dump['track_id']);
        $dump['track_dist'] = $this->get_dist('track', $dump['track_id']);
        $dump['track_dist_link'] = $this->bake_dist_links($dump['track_dist']);
        $dump = array_merge($dump, $this->get_artist($dump['artist_id']));

        ksort($dump);

        return $dump ?? [];
    }


    protected function get_rls(int $rls_id): array
    {
        $dump = $this->DB->query_single('
            SELECT
                rls.id AS rls_id,
                rls.name AS rls_name,
                rls.pub_date AS rls_pub_date,
                rls.upd_date AS rls_upd_date,
                rls.description AS rls_description,
                rls.is_freedl AS rls_is_freedl,
                rls.bandcamp_id AS rls_bandcamp_id,
                rls_type.name AS rls_type_name,
                artist.id AS artist_id,
                label.name AS label_name
            FROM rls
            LEFT JOIN artist ON artist.id = rls.artist_id
            LEFT JOIN rls_type ON rls_type.id = rls.rls_type_id
            LEFT JOIN label ON label.id = rls.label_id
            WHERE rls.id = :rls_id;',
            [
                ['rls_id', $rls_id, SQLITE3_INTEGER],
            ]
        );

        $dump['rls_coverart_file'] = $this->get_rls_coverart_file_path($dump['rls_id']);
        $dump['rls_track_list'] = $this->get_rls_track_list($dump['rls_id']);
        $dump['rls_track_count'] = count($dump['rls_track_list']);
        $dump['rls_media'] = $this->get_media('rls', $dump['rls_id']);
        $dump['rls_credit'] = $this->get_credit('rls', $dump['rls_id']);
        $dump['rls_dist'] = $this->get_dist('rls', $dump['rls_id']);
        $dump['rls_dist_link'] = $this->bake_dist_links($dump['rls_dist']);

        $dump = array_merge($dump, $this->get_artist($dump['artist_id']));

        ksort($dump);

        return $dump ?? [];
    }


    protected function get_credit(string $type, int $id): array
    {
        $dump = $this->DB->query('
            SELECT
                '.$type.'_credit.line
            FROM '.$type.'_credit
            WHERE '.$type.'_id = :id
            ORDER BY ROWID ASC;
            ',
            [
                ['id', $id, SQLITE3_INTEGER],
            ]
        );

        return array_map(function(array $v): string {
            return $v['line'];
        }, $dump) ?? [];
    }


    protected function get_dist(string $type, int $id): array
    {
        $dump = $this->DB->query('
            SELECT
                '.$type.'_dist.platform,
                '.$type.'_dist.url
            FROM '.$type.'_dist
            WHERE '.$type.'_id = :id
            ORDER BY LOWER(platform) ASC;',
            [
                ['id', $id, SQLITE3_INTEGER],
            ],
        );

        return $dump ?? [];
    }


    protected function get_media(string $type, int $id): array
    {
        $dump = $this->DB->query('
            SELECT
                '.$type.'_media.code AS media_code
            FROM '.$type.'_media
            WHERE '.$type.'_id = :id
            ORDER BY ROWID ASC;',
            [
                ['id', $id, SQLITE3_INTEGER],
            ],
        );

        return array_map(function(array $v): string {
            return $v['media_code'];
        }, $dump) ?? [];
    }


    protected function bake_dist_links(array $dist): array
    {
        return array_map(function(array $v) {
            return '<a href="'.$v['url'].'">'.ucwords($v['platform']).'</a>';
        }, $dist) ?? [];
    }


    protected function get_rls_coverart_file_path(int $rls_id, ?string $size = null): array | string
    {
        $tn  = './file/cover/'.$rls_id.'-tn.jpg';
        $med = './file/cover/'.$rls_id.'-med.jpg';
        $big = './file/cover/'.$rls_id.'-big.png';

        switch ($size)
        {
            case 'tn':
                return $tn;
                break;

            case 'med':
                return $med;
                break;

            case 'big':
                return $big;
                break;

            default:
                return [
                    'tn' => $tn,
                    'med' => $med,
                    'big' => $big,
                ];
        }
    }
}
