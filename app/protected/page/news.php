<?php
if (isset($this->route['var']['date'])) {
    $q = 'SELECT id, postedOn, items FROM news WHERE postedOn = :postedOn ORDER BY id DESC;';
    $v = array(
        array('postedOn', $this->route['var']['date'], SQLITE3_TEXT),
    );
}
else {
    $q = 'SELECT id, postedOn, items FROM news ORDER BY id DESC;';
    $v = array();
}

$news = $this->DB->query($q, $v);
?>




<h2>/<a href="<?php print($this->routeURL('news')); ?>">news</a></h2>
<?php
foreach ($news as $v) {
    $items = array();
    foreach (jdec($v['items']) as $i) {
        // TODO: create custom markdown-like parser later to use across the app. Example:
        //       $i = preg_replace('/\[(.*)\]\((.*)\)/', '<a href="$1">$2</a>', $i);
        //       $i = preg_replace('/routeURL\((.*)\)/', $this->routeURL('${1}'), $i);
        //       etc.
        $items[] = sprintf('<li>%s</li>', $i);
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
