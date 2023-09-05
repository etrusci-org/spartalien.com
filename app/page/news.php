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
    <h2>News from <?php print($news[0]['news_pub_date']); ?></h2>

    <div class="box">
        <?php
        foreach ($news as $v) {
            printf('<p>%1$s</p>',
                $this->_lazytext($v['news_text']),
            );
        }
        ?>
    </div>

    <!-- <pre><?php print_r($news); ?></pre> -->
<?php endif; ?>




<div <?php print(($news) ? 'class="more"' : ''); ?>>

    <h2><?php print((!$news) ? 'Notable News & Updates' : 'More News ...'); ?></h2>

    <div class="box">
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
    </div>
</div>
