<?php
$news = $this->get_latest_news_list();
$rls = $this->get_latest_rls_list();
?>


<h2>Welcome, most likely 3-dimensional being ...</h2>


<div class="grid-x-2">
    <div class="box">
        <h3>Latest Music Releases</h3>
        <ul>
            <?php
            foreach ($rls as $v) {
                printf(
                    '<li>
                        <a href="./music/id:%1$s">%2$s</a>
                        <span class="meta">[%3$s]</span>
                    </li>',
                    $v['rls_id'],
                    $v['rls_name'],
                    $v['rls_type_name'],
                );
            }
            ?>
        </ul>
        <p><a href="./music">more...</a></p>
    </div>

    <div class="box">
        <h3>Latest News</h3>
        <ul>
            <?php
            foreach ($news as $v) {
                printf('
                    <li>%1$s</li>',
                    $this->_lazytext($v['news_text']),
                );
            }
            ?>
        </ul>
        <p><a href="./news">more...</a></p>
    </div>
</div>


<div class="grid-x-2">
    <div class="box">
        <h3>Insider Club</h3>
        <a href="//eepurl.com/dqYlHr" class="img"><img src="./res/newsletter-qr.png" alt="Newsletter QR-Code"></a>
    </div>

    <div class="box">
        <h3>Elsewhere</h3>
        <p><?php print(implode(' &middot; ', array_map(fn(array $v) => sprintf('<a href="%2$s">%1$s</a>', $v[0], $v[1]), $var_elsewhere))); ?></p>
    </div>
</div>
