<?php
declare(strict_types=1);
namespace s9com;


class Page extends Core
{

    protected function get_visual_list(): array
    {
        $dump = $this->DB->query('
            SELECT
                visual.id AS visual_id,
                visual.pub_date AS visual_pub_date,
                visual.name AS visual_name,
                visual.description AS visual_description
            FROM visual
            ORDER BY visual.pub_date DESC, visual.id DESC;'
        );

        foreach ($dump as $k => $v) {
            $dump[$k]['visual_preview_image'] = $this->_get_preview_image_paths('visual', $v['visual_id']);
            ksort($dump[$k]);
        }

        return $dump ?? [];
    }


    protected function get_visual(int $visual_id): array
    {
        $dump = $this->DB->query_single('
            SELECT
                visual.id AS visual_id,
                visual.pub_date AS visual_pub_date,
                visual.name AS visual_name,
                visual.description AS visual_description
            FROM visual
            WHERE visual_id = :visual_id
            ORDER BY visual.pub_date DESC;',
            [
                ['visual_id', $visual_id, SQLITE3_INTEGER],
            ]
        );

        $dump['visual_preview_image'] = $this->_get_preview_image_paths('visual', $dump['visual_id']);
        $dump['visual_media'] = $this->get_media($dump['visual_id']);

        ksort($dump);

        return $dump ?? [];
    }


    protected function get_media(int $visual_id): array
    {
        $dump = $this->DB->query('
            SELECT
                visual_media.code AS visual_media_code
            FROM visual_media
            WHERE visual_id = :visual_id
            ORDER BY ROWID ASC;',
            [
                ['visual_id', $visual_id, SQLITE3_INTEGER],
            ]
        );

        return array_map(function(array $v): string {
            return $v['visual_media_code'];
        }, $dump) ?? [];
    }
}
