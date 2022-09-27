<?php
$news = $this->getNews('list');

if (!$news) {
    print('error: could not fetch news');
    exit(1);
}

print('<?xml version="1.0" encoding="utf-8"?>'.PHP_EOL);
?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <title><?php print($this->conf['siteTitle']); ?></title>
	<subtitle>Notable updates and changes.</subtitle>
    <updated><?php print(date('Y-m-d\TH:i:s\Z')); ?></updated>
    <id>tag:spartalien.com,2022:v8</id>
    <link rel="self" type="application/atom+xml" href="<?php printf('%1$s%2$s', $this->conf['baseURL'], $this->routeURL('news.atom')); ?>"/>
    <rights>Copyright (c) 2016-<?php print(date('Y')); ?> SPARTALIEN.COM</rights>
    <?php
    foreach ($news as $v) {
        $items = implode(' + ', array_map(function(string $v): string {
            return $this->parseLazyInput($v);
        }, $v['items']));
        printf('
            <entry>
                <title>NEWS FROM %3$s</title>
                <link href="%2$s"/>
                <id>tag:spartalien.com,%3$s:news-%1$s</id>
                <updated>%3$sT00:00:00Z</updated>
                <author>
                    <name>SPARTALIEN</name>
                </author>
                <content>
                    %4$s
                </content>
            </entry>',
            $v['id'],
            sprintf('%1$s%2$s', $this->conf['baseURL'], $this->routeURL('news/id:%s', [$v['id']])),
            $v['postedOn'],
            htmlspecialchars(strip_tags($items), ENT_HTML5),
        );
    }
    ?>
</feed>
