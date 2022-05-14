<?php
$newsList = $this->getNews('list');
$newsByDate = $this->getNews('byDate');


if (!$newsByDate) {
    print('<h2>/news</h2>');
}
else {
    $items = array();
    foreach (jdec($newsByDate['items']) as $i) {
        $items[] = sprintf('<li>%s</li>', $this->parseLazyText($i));
    }
    $items = implode('', $items);
    printf('
        <h2>/news : %1$s</h2>
        <div>
            <ul>
                %3$s
            </ul>
        </div>
        ',
        $newsByDate['postedOn'],
        $this->routeURL(sprintf('news/date:%s', $newsByDate['postedOn'])),
        $items,
    );
    print('<hr><h3>more news...</h3>');
}

foreach ($newsList as $v) {
    $items = array();
    foreach (jdec($v['items']) as $i) {
        $items[] = sprintf('<li>%s</li>', $this->parseLazyText($i));
    }
    $items = implode('', $items);
    printf('
        <div>
            <h3><a href="%2$s">%1$s</a></h3>
            <ul>%3$s</ul>
        </div>
        ',
        $v['postedOn'],
        $this->routeURL(sprintf('news/date:%s', $v['postedOn'])),
        $items,
    );
}
?>
