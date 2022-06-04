<?php
$newsList = $this->getNews('list');
$newsByDate = $this->getNews('byDate');


if (!$newsByDate) {
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


// new by date
if ($newsByDate) {
    $items = array();
    foreach ($newsByDate['items'] as $i) {
        $items[] = sprintf('<p>%s</p>', $this->parseLazyInput($i));
    }
    $items = implode('', $items);

    printf('
        <div class="box">
            <h2>NEWS FROM %1$s</h2>
            %3$s
        </div>
        ',
        $newsByDate['postedOn'],
        $this->routeURL(sprintf('news/date:%s', $newsByDate['postedOn'])),
        $items,
    );
}


// news list
print('<div class="box">');

if ($newsByDate) {
    print('<h3>MORE NEWS ...</h3>');
}

print('<ul>');

foreach ($newsList as $v) {
    $items = array();
    foreach ($v['items'] as $i) {
        $items[] = sprintf('%s', $this->parseLazyInput($i));
    }
    $items = implode(' + ', $items);

    printf('
        <li>
            <a href="%2$s"%3$s>%1$s</a>:
            %4$s
        </li>
        ',
        $v['postedOn'],
        $this->routeURL(sprintf('news/id:%s', $v['id'])),
        (isset($this->route['var']['id']) && $this->route['var']['id'] == $v['id']) ? ' class="active"' : '',
        $items,
    );
}
print('</ul></div>');





/*
$newsList = $this->getNews('list');
$newsByDate = $this->getNews('byDate');


print('
    <div class="box">
        <h2>NEWS</h2>
        <p>
            Notable updates and changes.
            Subscribe to the <a href="#">Newsletter</a> to get these news directly in your inbox.
            Follow me on <a href="#">Twitter</a> and <a href="#">Instagram</a> for random bleeps in between.
        </p>
    </div>
');


// new by date
if ($newsByDate) {
    $items = array();
    foreach ($newsByDate['items'] as $i) {
        $items[] = sprintf('<p>%s</p>', $this->parseLazyInput($i));
    }
    $items = implode('', $items);

    printf('
        <div class="box">
            <h3>NEWS FROM %1$s</h3>
            %3$s
        </div>
        ',
        $newsByDate['postedOn'],
        $this->routeURL(sprintf('news/date:%s', $newsByDate['postedOn'])),
        $items,
    );
}


// news list
print('<div class="box">');

if ($newsByDate) {
    print('<h4>MORE NEWS...</h4>');
}

print('<ul>');

foreach ($newsList as $v) {
    $items = array();
    foreach ($v['items'] as $i) {
        $items[] = sprintf('%s', $this->parseLazyInput($i));
    }
    $items = implode(' + ', $items);

    printf('
        <li>
            <a href="%2$s"%3$s>%1$s</a>:
            %4$s
        </li>
        ',
        $v['postedOn'],
        $this->routeURL(sprintf('news/id:%s', $v['id'])),
        (isset($this->route['var']['id']) && $this->route['var']['id'] == $v['id']) ? ' class="active"' : '',
        $items,
    );
}
print('</ul></div>');
*/
