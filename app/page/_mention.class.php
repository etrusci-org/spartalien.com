<?php
declare(strict_types=1);
namespace s9com;


class Page extends Core
{

    protected function get_mention_list(): array
    {
        $dump = $this->DB->query('
            SELECT
                mention.id AS mention_id,
                mention.subject AS mention_subject,
                mention.description AS mention_description
            FROM mention
            ORDER BY mention.subject ASC;'
        );

        return $dump ?? [];
    }


    protected function get_mention(int $mention_id): array
    {
        $dump = $this->DB->query_single('
            SELECT
                mention.id AS mention_id,
                mention.subject AS mention_subject,
                mention.description AS mention_description
            FROM mention
            WHERE mention_id = :mention_id
            ORDER BY mention.subject ASC;',
            [
                ['mention_id', $mention_id, SQLITE3_INTEGER],
            ]
        );

        $dump['mention_media'] = $this->get_media($mention_id);

        ksort($dump);

        return $dump ?? [];
    }


    protected function get_media(int $mention_id): array
    {
        $dump = $this->DB->query('
            SELECT
                mention_media.code AS mention_media_code
            FROM mention_media
            WHERE mention_id = :mention_id
            ORDER BY ROWID ASC;',
            [
                ['mention_id', $mention_id, SQLITE3_INTEGER],
            ]
        );

        return array_map(function(array $v): string {
            return $v['mention_media_code'];
        }, $dump) ?? [];
    }
}
