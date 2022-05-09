<?php
$q = 'SELECT id, postedOn, items FROM news ORDER BY postedOn DESC;';
$newsList = $this->DB->query($q);

$newsByDate = null;
if (isset($this->route['var']['date'])) {
    $q = 'SELECT id, postedOn, items FROM news WHERE postedOn = :postedOn ORDER BY postedOn DESC;';
    $v = array(
        array('postedOn', $this->route['var']['date'], SQLITE3_TEXT),
    );
    $newsByDate = $this->DB->querySingle($q, $v);
    if (!$newsByDate) {
        printf('<div class="error">could not find news by date: %s.</div>', $this->route['var']['date']);
    }
}
?>






<?php
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
            <ul>
                %3$s
            </ul>
        </div>
        ',
        $v['postedOn'],
        $this->routeURL(sprintf('news/date:%s', $v['postedOn'])),
        $items,
    );
}
?>
