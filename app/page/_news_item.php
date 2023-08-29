<h2>News From <?php print($news[0]['news_pub_date']); ?></h2>

<?php
foreach ($news as $v) {
    printf('
        <p>%1$s</p>',
        $this->_lazytext($v['news_text']),
    );
}
?>
