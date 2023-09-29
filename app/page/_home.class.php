<?php
declare(strict_types=1);
namespace s9com;


class Page extends Core
{
    protected function get_latest_news_list(int $limit = 4): array
    {
        $dump = $this->DB->query('
            SELECT
                news.id AS news_id,
                news.pub_date AS news_pub_date,
                news_text.text AS news_text
            FROM news
            LEFT JOIN news_text ON news_text.news_id = news.id
            ORDER BY news.pub_date DESC, news_text.ROWID DESC
            LIMIT :limit;',
            [
                ['limit', $limit, SQLITE3_INTEGER],
            ]
        );

        return $dump ?? [];
    }


    protected function get_latest_rls_list(int $limit = 4): array
    {
        $dump = $this->DB->query('
            SELECT
                rls.id AS rls_id,
                rls.name AS rls_name,
                rls.pub_date AS rls_pub_date,
                rls_type.name AS rls_type_name,
                CASE
                    WHEN rls.upd_date IS NULL
                        THEN REPLACE(rls.pub_date, "-", "")
                        ELSE REPLACE(rls.upd_date, "-", "")
                END rls_list_order
            FROM rls
            LEFT JOIN rls_type ON rls_type.id = rls.rls_type_id
            ORDER BY rls_list_order DESC
            LIMIT :limit;',
            [
                ['limit', $limit, SQLITE3_INTEGER],
            ]
        );

        return $dump ?? [];
    }
}
