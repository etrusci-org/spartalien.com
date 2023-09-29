<?php
declare(strict_types=1);
namespace s9com;


class Page extends Core
{

    protected function get_stuff_list(): array
    {
        $dump = $this->DB->query('
            SELECT
                stuff.id AS stuff_id,
                stuff.name AS stuff_name,
                stuff.description AS stuff_description
            FROM stuff
            ORDER BY LOWER(stuff.name) ASC;'
        );

        return $dump ?? [];
    }


    protected function get_stuff(int $stuff_id): array
    {
        $dump = $this->DB->query_single('
            SELECT
                stuff.id AS stuff_id,
                stuff.name AS stuff_name,
                stuff.description AS stuff_description
            FROM stuff
            WHERE stuff_id = :stuff_id
            LIMIT 1;',
            [
                ['stuff_id', $stuff_id, SQLITE3_INTEGER],
            ]
        );

        $dump['stuff_media'] = $this->get_media($stuff_id);

        return $dump ?? [];
    }


    protected function get_media(int $stuff_id): array
    {
        $dump = $this->DB->query('
            SELECT
                stuff_media.code AS stuff_media_code
            FROM stuff_media
            WHERE stuff_id = :stuff_id
            ORDER BY stuff_media.ROWID ASC;',
            [
                ['stuff_id', $stuff_id, SQLITE3_INTEGER],
            ]
        );

        return array_map(function(array $v): string {
            return $v['stuff_media_code'];
        }, $dump) ?? [];
    }
}
