<?php
declare(strict_types=1);
namespace s9com;


class Page extends Core
{
    protected function get_news_list(): array
    {
        $dump = $this->DB->query('
            SELECT
                news.id AS news_id,
                news.pub_date AS news_pub_date,
                news_text.text AS news_text
            FROM news
            LEFT JOIN news_text ON news_text.news_id = news.id
            ORDER BY news.pub_date DESC;'
        );

        foreach ($dump as $k => $v) {
            ksort($dump[$k]);
        }

        return $dump ?? [];
    }


    protected function get_news(int $news_id): array
    {
        $dump = $this->DB->query('
            SELECT
                news_text.text AS news_text,
                news.pub_date AS news_pub_date
            FROM news_text
            LEFT JOIN news ON news.id = news_text.news_id
            WHERE news_text.news_id = :news_id
            ORDER BY news.pub_date DESC;',
            [
                ['news_id', $news_id, SQLITE3_INTEGER],
            ]
        );

        foreach ($dump as $k => $v) {
            ksort($dump[$k]);
        }

        return $dump ?? [];
    }



    // protected function get_news_list(): array
    // {
    //     $dump = $this->DB->query('
    //         SELECT
    //             news.id AS news_id,
    //             news.pub_date AS news_pub_date,
    //             news_text.text AS news_text
    //         FROM news
    //         LEFT JOIN news_text ON news_text.news_id = news.id
    //         ORDER BY news.pub_date DESC;'
    //     );

    //     foreach ($dump as $k => $v) {
    //         ksort($dump[$k]);
    //     }

    //     return $dump ?? [];
    // }


    // protected function get_news(int $news_id): array
    // {
    //     $dump = $this->DB->query('
    //         SELECT
    //             news_text.text AS news_text,
    //             news.pub_date AS news_pub_date
    //         FROM news_text
    //         LEFT JOIN news ON news.id = news_text.news_id
    //         WHERE news_text.news_id = :news_id
    //         ORDER BY news.pub_date DESC;',
    //         [
    //             ['news_id', $news_id, SQLITE3_INTEGER],
    //         ]
    //     );

    //     var_dump($dump);

    //     foreach ($dump as $k => $v) {
    //         ksort($dump[$k]);
    //     }

    //     return $dump ?? [];
    // }
}
