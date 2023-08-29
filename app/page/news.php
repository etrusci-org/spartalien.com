<?php
$news_list = $this->get_news_list();

$news = [];
if (isset($this->Router->route['var']['id'])) {
    $news = $this->get_news((int) $this->Router->route['var']['id']);
}

// var_dump($news);
// var_dump($news_list);
?>


<?php if ($news): ?>
    <section>
        <h2>News from <?php print($news[0]['news_pub_date']); ?></h2>

        <pre><?php print_r($news); ?></pre>
    </section>
<?php endif; ?>


<section <?php print(($news) ? 'class="more"' : ''); ?>>
    <?php print((!$news) ? '<h2>Notable Updates And Changes</h2>' : '<h3>More News ...</h3>'); ?>

    <ul>
        <?php
        foreach ($news_list as $v) {
            printf('
                <li>
                    <a href="./news/id:%1$s"%4$s>%2$s</a>
                    &middot; %3$s
                </li>',
                $v['news_id'],
                $v['news_pub_date'],
                $this->_lazytext($v['news_text']),
                (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['news_id']) ? ' class="active"' : '',
            );
        }
        ?>
    </ul>
</section>





<!--
<?php
if ($news) {
    include $this->conf['page_dir'].'/_news_item.php';
}
?>



<section <?php print(($news) ? 'class="more"' : ''); ?>>

    <?php print((!$news) ? '<h2>Notable Updates And Changes</h2>' : '<h3>More News ...</h3>'); ?>

    <ul>
        <?php
        foreach ($news_list as $v) {
            printf('
                <li>
                    <a href="./news/id:%1$s"%4$s>%2$s</a>
                    &middot; %3$s
                </li>',
                $v['news_id'],
                $v['news_pub_date'],
                $this->_lazytext($v['news_text']),
                (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['news_id']) ? ' class="active"' : '',
            );
        }
        ?>
    </ul>

</section> -->
