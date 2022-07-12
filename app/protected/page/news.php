<?php
$newsList = $this->getNews('list');
$newsByID = $this->getNews('byID');




// news list index
if (!$newsByID) {
    printf('
        <div class="box">
            <h2>NOTABLE UPDATES AND CHANGES</h2>
            <a href="%1$s" class="btn">Newsletter</a>
            <a href="%2$s" class="btn">Twitter</a>
            <a href="%3$s" class="btn">Instagram</a>
        </div>',
        $this->conf['elsewhere']['newsletter'][1],
        $this->conf['elsewhere']['twitter'][1],
        $this->conf['elsewhere']['instagram'][1],
    );
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
    if ($newsByID) {
        print('<div class="moreSpacer"></div>');
    }

    print('<div class="box">');

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
