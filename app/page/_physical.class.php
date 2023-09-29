<?php
declare(strict_types=1);
namespace s9com;


class Page extends Core
{
    protected function get_phy_list(): array
    {
        $dump = $this->DB->query('
            SELECT
                phy.id AS phy_id,
                phy.name AS phy_name
            FROM phy
            ORDER BY phy.id DESC;'
        );

        foreach ($dump as $k => $v) {
            $dump[$k]['phy_preview_image'] = $this->_get_preview_image_paths('phy', $v['phy_id']);
        }

        return $dump ?? [];
    }


    protected function get_phy(int $phy_id): array
    {
        $dump = $this->DB->query_single('
            SELECT
                phy.id AS phy_id,
                phy.name AS phy_name,
                phy.description AS phy_description
            FROM phy
            WHERE phy.id = :phy_id
            LIMIT 1;',
            [
                ['phy_id', $phy_id, SQLITE3_INTEGER],
            ]
        );

        $dump['phy_preview_image'] = $this->_get_preview_image_paths('phy', $dump['phy_id']);
        $dump['phy_media'] = $this->get_media($phy_id);

        return $dump ?? [];
    }


    protected function get_media(int $phy_id): array
    {
        $dump = $this->DB->query('
            SELECT
                phy_media.code AS phy_media_code
            FROM phy_media
            WHERE phy_id = :phy_id
            ORDER BY phy_media.ROWID ASC;',
            [
                ['phy_id', $phy_id, SQLITE3_INTEGER],
            ]
        );

        return array_map(function(array $v): string {
            return $v['phy_media_code'];
        }, $dump) ?? [];
    }
}
