<?php
$news_list = $this->get_news_list();

$news = [];
if (isset($this->Router->route['var']['id'])) {
    $news = $this->get_news((int) $this->Router->route['var']['id']);
}

// var_dump($news_list);
?>


<section>

    <?php if (!$news) : ?>

        <h2>News</h2>

    <?php else: ?>

        <h2>News from <?php print($news[0]['news_pub_date']); ?></h2>

        <pre><?php print_r($news); ?></pre>

        </section>
        <section class="more">
            <h3>More News ...</h3>

    <?php endif; ?>

    <ul>
        <?php
        foreach ($news_list as $v) {
            printf('
                <li>
                    <a href="./news/id:%1$s">%2$s</a> &middot;
                    %3$s
                </li>',
                $v['news_id'],
                $v['news_pub_date'],
                $this->_lazytext($v['news_text']),
            );
        }
        ?>
    </ul>

</section>
