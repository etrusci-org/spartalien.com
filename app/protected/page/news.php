<?php
$newsList = $this->getNews('list');
$newsByDate = $this->getNews('byDate');


// header info
print('
    <h2>/news</h2>
    <p>[ <a href="#">Newsletter</a> &middot; <a href="#">Twitter</a> &middot; <a href="#">Instagram</a> ]</p>
');


// new by date
if ($newsByDate) {
    $items = array();
    foreach ($newsByDate['items'] as $i) {
        $items[] = sprintf('<li>%s</li>', $this->parseLazyInput($i));
    }
    $items = implode('', $items);

    printf('
        <h3>news from %1$s</h3>
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

    print('<hr><h4>more news...</h4>');
}


// news list
foreach ($newsList as $v) {
    $items = array();
    foreach ($v['items'] as $i) {
        $items[] = sprintf('<li>%s</li>', $this->parseLazyInput($i));
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
