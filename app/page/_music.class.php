<?php
declare(strict_types=1);
namespace s9com;


class Page extends Core
{
    protected function get_rls_list(?int $limit = null): array
    {
        $query_limit = ($limit) ? 'LIMIT '.$limit : '';

        $dump = $this->DB->query('
            SELECT
                rls.id AS rls_id,
                rls.name AS rls_name,
                rls.pub_date AS rls_pub_date,
                rls.upd_date AS rls_upd_date,
                rls.is_freedl AS rls_is_freedl,
                rls_type.id AS rls_type_id,
                rls_type.name AS rls_type_name,
                rls.artist_id AS artist_id,
                artist.name AS artist_name,
                CASE
                    WHEN rls.upd_date IS NULL
                        THEN REPLACE(rls.pub_date, "-", "")
                        ELSE REPLACE(rls.upd_date, "-", "")
                END rls_list_order
            FROM rls
            LEFT JOIN rls_type ON rls_type.id = rls.rls_type_id
            LEFT JOIN artist ON artist.id = rls.artist_id
            ORDER BY rls_list_order DESC
            '.$query_limit.';',
        );

        foreach ($dump as $k => $v) {
            $dump[$k]['rls_preview_image'] = $this->_get_preview_image_paths('rls', $v['rls_id']);
            $dump[$k]['rls_is_freedl'] = boolval($dump[$k]['rls_is_freedl']);
        }

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
                rls_type.id AS rls_type_id,
                rls_type.name AS rls_type_name,
                artist.id AS artist_id,
                artist.name AS artist_name,
                label.id AS label_id,
                label.name AS label_name,
                label.url AS label_url
            FROM rls
            LEFT JOIN rls_type ON rls_type.id = rls.rls_type_id
            LEFT JOIN artist ON artist.id = rls.artist_id
            LEFT JOIN label ON label.id = rls.label_id
            WHERE rls.id = :rls_id;',
            [
                ['rls_id', $rls_id, SQLITE3_INTEGER],
            ]
        );


        $dump['rls_preview_image'] = $this->_get_preview_image_paths('rls', $dump['rls_id']);
        $dump['rls_is_freedl'] = boolval($dump['rls_is_freedl']);
        $dump['rls_track_list'] = $this->get_rls_track_list($dump['rls_id']);
        $dump['rls_track_count'] = count($dump['rls_track_list']);
        $dump['rls_runtime_total'] = array_sum(array_map(fn(array $v): int => $v['track_runtime'], $dump['rls_track_list']));
        $dump['rls_runtime_total_human'] = $this->_seconds_to_dhms($dump['rls_runtime_total']);
        $dump['rls_credit'] = $this->get_credit('rls', $dump['rls_id']);
        $dump['rls_media'] = $this->get_media('rls', $dump['rls_id']);
        $dump['rls_dist'] = $this->get_dist('rls', $dump['rls_id']);

        return $dump ?? [];
    }


    protected function get_rls_track_list(int $rls_id): array
    {
        $dump = $this->DB->query('
            SELECT
                track.id AS track_id,
                track.name AS track_name,
                track.runtime AS track_runtime,
                artist.id AS artist_id,
                artist.name AS artist_name
            FROM rls_tracklist
            LEFT JOIN track ON track.id = rls_tracklist.track_id
            LEFT JOIN artist ON artist.id = track.artist_id
            WHERE rls_id = :rls_id
            ORDER BY track.id ASC;',
            [
                ['rls_id', $rls_id, SQLITE3_INTEGER],
            ]
        );

        $track_order = 1;
        foreach ($dump as $k => $v) {
            $dump[$k]['track_runtime_human'] = $this->_seconds_to_dhms($v['track_runtime']);
            $dump[$k]['track_credit'] = $this->get_credit('track', $v['track_id']);
            $dump[$k]['track_order'] = $track_order++;
        }

        return $dump ?? [];
    }


    protected function get_catalog_track_list(): array
    {
        $dump = $this->DB->query('
            SELECT
                track.id AS track_id,
                track.name AS track_name,
                track.crea_year AS track_crea_year,
                track.runtime AS track_runtime,
                track.artist_id AS artist_id,
                artist.name AS artist_name
            FROM track
            LEFT JOIN artist ON artist.id = track.artist_id
            ORDER BY LOWER(track.name) ASC;',
        );

        foreach ($dump as $k => $v) {
            $dump[$k]['track_runtime_human'] = $this->_seconds_to_dhms($v['track_runtime']);
        }

        return $dump ?? [];
    }


    protected function get_track(int $track_id): array
    {
        $dump = $this->DB->query_single('
            SELECT
                track.id AS track_id,
                track.name AS track_name,
                track.runtime AS track_runtime,
                track.bandcamp_id AS track_bandcamp_id,
                artist.id AS artist_id,
                artist.name AS artist_name
            FROM track
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
        $dump['track_appears_on'] = $this->get_appears_on($dump['track_id']);

        return $dump ?? [];
    }


    protected function get_appears_on(int $track_id): array
    {
        $dump = $this->DB->query('
            SELECT
                rls_tracklist.rls_id AS rls_id,
                rls.name AS rls_name
            FROM rls_tracklist
            LEFT JOIN track ON track.id = rls_tracklist.track_id
            LEFT JOIN rls ON rls.id = rls_tracklist.rls_id
            WHERE track.id = :track_id;',
            [
                ['track_id', $track_id, SQLITE3_INTEGER],
            ]
        );

        return $dump ?? [];
    }


    protected function get_credit(string $type, int $id): array
    {
        $dump = $this->DB->query('
            SELECT
                '.$type.'_credit.line
            FROM '.$type.'_credit
            WHERE '.$type.'_id = :id
            ORDER BY '.$type.'_credit.ROWID ASC;',
            [
                ['id', $id, SQLITE3_INTEGER],
            ]
        );

        return array_map(fn(array $v): string => $v['line'], $dump);
    }


    protected function get_media(string $type, int $id): array
    {
        $dump = $this->DB->query('
            SELECT
                '.$type.'_media.code AS media_code
            FROM '.$type.'_media
            WHERE '.$type.'_id = :id
            ORDER BY '.$type.'_media.ROWID ASC;',
            [
                ['id', $id, SQLITE3_INTEGER],
            ],
        );

        return array_map(fn(array $v): string => $v['media_code'], $dump);
    }


    protected function get_dist(string $type, int $id): array
    {
        $dump = $this->DB->query('
            SELECT
                '.$type.'_dist.platform,
                '.$type.'_dist.url
            FROM '.$type.'_dist
            WHERE '.$type.'_id = :id
            ORDER BY LOWER('.$type.'_dist.platform) ASC;',
            [
                ['id', $id, SQLITE3_INTEGER],
            ],
        );

        return $dump ?? [];
    }


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
}
