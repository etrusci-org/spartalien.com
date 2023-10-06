<?php
$news_list = $this->get_news_list();

$news = [];
if (isset($this->Router->route['var']['id'])) {
    $news = $this->get_news((int) $this->Router->route['var']['id']);
}
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
<?php endif; ?>




<div <?php print(($news) ? 'class="more"' : ''); ?>>
    <h2><?php print((!$news) ? 'Notable News & Updates' : 'More News ...'); ?></h2>

    <?php if (!$news): ?>
        <div class="box">
            <p>
                <a href="<?php print($var_elsewhere['newsletter'][1]); ?>">Subscribe to the newsletter</a>
                to get the news and related insider infos I usually don't post anywhere else directly in your email inbox.
                Or follow me on <a href="<?php print($var_elsewhere['instagram'][1]); ?>">Instagram</a> for random bleeps in between.
                There's also an <a href="./news.atom">Atom Feed<a> you can subscribe to.
            </p>
        </div>
    <?php endif; ?>

    <div class="box">
        <ul>
            <?php
            $dump = [];
            foreach ($news_list as $v) {
                $dump[$v['news_pub_date']][] = $v;
            }

            foreach ($dump as $date => $items) {
                $items = implode(' + ', array_map(fn(array $v) => sprintf('%s', $this->_lazytext($v['news_text'])), $items));

                printf('
                    <li>
                        <a href="./news/id:%1$s"%4$s>%2$s</a>
                        &middot; %3$s
                    </li>',
                    $dump[$date][0]['news_id'],
                    $date,
                    $items,
                    (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $dump[$date][0]['news_id']) ? ' class="active"' : '',
                );
            }
            ?>
        </ul>
    </div>
</div>
