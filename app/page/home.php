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
                        <span class="meta">%3$s [%4$s]</span>
                        &middot; <a href="./music/id:%1$s">%2$s</a>
                    </li>',
                    $v['rls_id'],
                    $v['rls_name'],
                    $v['rls_pub_date'],
                    $v['rls_type_name'],
                );
            }
            ?>
        </ul>
    </div>

    <div class="box">
        <h3>Latest News</h3>
        <ul>
            <?php
            foreach ($news as $v) {
                printf('
                    <li>
                        <span class="meta">%2$s</span>
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



<div class="grid-x-2">

    <div class="box">
        <h3>Insider Club</h3>
        <img src="./res/newsletter-qr.png" alt="Newsletter QR-Code">
    </div>

    <div class="box">
        <h3>Elsewhere</h3>
        <ul class="grid-x-3">
            <?php print(implode('', array_map(fn(array $v) => sprintf('<li><a href="%2$s">%1$s</a></li>', $v[0], $v[1]), $var_elsewhere))); ?>
        </ul>
    </div>

</div>
