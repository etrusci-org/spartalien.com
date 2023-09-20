<?php
$news_list = $this->get_news_list();


print('<?xml version="1.0" encoding="utf-8"?>'."\n");
?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <title><?php $this->_phsc($this->conf['site_title']); ?></title>
    <subtitle>Notable News &amp; Updates</subtitle>
    <updated><?php print(date('Y-m-d\TH:i:s\Z', strtotime($news_list[0]['news_pub_date']))); ?></updated>
    <id>tag:spartalien.com,<?php print(date('Y')); ?>:v9</id>
    <link rel="self" type="application/atom+xml" href="<?php printf($this->conf['site_url'].'news.atom'); ?>"/>
    <rights>Copyright <?php print(date('Y')); ?> SPARTALIEN.COM</rights>
    <?php
    $dump = [];
    foreach ($news_list as $v) {
        $dump[$v['news_pub_date']][] = $v;
    }

    foreach ($dump as $date => $items) {
        $items = implode('<br>', array_map(fn(array $v) => sprintf('<li>%s</li>', $this->_lazytext($v['news_text'])), $items));

        printf('
            <entry><title>NEWS FROM %4$s</title><link href="%1$snews/id:%3$s"/><id>tag:spartalien.com,%2$s:news-%3$s</id><updated>%4$sT00:00:00Z</updated><author><name>SPARTALIEN</name></author><content type="html">%5$s</content></entry>',
            $this->conf['site_url'],
            date('Y'),
            $dump[$date][0]['news_id'],
            $date,
            $this->_hsc('<ul>'.$items.'</ul>'),
        );
    }
    ?>

</feed>
