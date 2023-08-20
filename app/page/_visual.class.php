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
                visual.name AS visual_name,
                visual.description AS visual_description
            FROM visual
            ORDER BY visual.pub_date DESC;'
        );

        return $dump ?? [];
    }


    protected function get_visual(int $visual_id): array
    {
        $dump = $this->DB->query_single('
            SELECT
                visual.id AS visual_id,
                visual.name AS visual_name,
                visual.description AS visual_description
            FROM visual
            WHERE visual_id = :visual_id
            ORDER BY visual.pub_date DESC;',
            [
                ['visual_id', $visual_id, SQLITE3_INTEGER],
            ]
        );

        $dump['preview_image_file'] = $this->get_preview_image_file_path($visual_id);
        $dump['visual_media'] = $this->get_media($visual_id);

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


    protected function get_preview_image_file_path(int $visual_id, ?string $size = null): array | string
    {
        $tn  = 'file/preview/visual/'.$visual_id.'-tn.jpg';
        $med = 'file/preview/visual/'.$visual_id.'-med.jpg';
        $big = 'file/preview/visual/'.$visual_id.'-big.png';

        return match($size) {
            'tn' => $tn,
            'med' => $med,
            'big' => $big,
            default => [
                'tn' => $tn,
                'med' => $med,
                'big' => $big,
            ],
        };
    }
}
