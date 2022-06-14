<?php
$newsList = $this->getNews('list');
$newsByID = $this->getNews('byID');




// news list index
if (!$newsByID) {
    print('
        <div class="box">
            <h2>NOTABLE UPDATES AND CHANGES</h2>
            <p>
                Subscribe to the <a href="#">Newsletter</a> to get these news directly in your inbox.
                Follow me on <a href="#">Twitter</a> and <a href="#">Instagram</a> for random bleeps in between.
            </p>
        </div>
    ');
}




// news by id
if ($newsByID) {
    $nws = $newsByID;

    $items = implode(' ', array_map(function(string $v): string {
        return sprintf('<p>%s</p>', $this->parseLazyInput($v));
    }, $nws['items']));

    printf('
        <div class="box">
            <h2>NEWS FROM %1$s</h2>
            %2$s
        </div>',
        $nws['postedOn'],
        $items,
    );
}




// news list
if ($newsList) {
    printf('<div class="box%1$s">', ($newsByID) ? ' more' : '');

    if ($newsByID) {
        print('<h3>MORE NEWS ...</h3>');
    }

    print('<ul>');

    foreach ($newsList as $v) {
        $items = implode(' + ', array_map(function($v) {
            return $this->parseLazyInput($v);
        }, $v['items']));

        printf('
            <li>
                <a href="%2$s"%3$s>%1$s</a> &middot;
                %4$s
            </li>',
            $v['postedOn'],
            $this->routeURL(sprintf('news/id:%s', $v['id'])),
            (isset($this->route['var']['id']) && $this->route['var']['id'] == $v['id']) ? ' class="active"' : '',
            $items,
        );
    }

    print('</ul>');
    print('</div>');
}
