<?php
$stuffList = $this->getStuff('list');
$stuffByID = $this->getStuff('byID');




// stuff list index
if (!$stuffByID) {
    print('
        <div class="box">
            <h2>MISCELLANEOUS STUFF</h2>
        </div>
    ');
}




// stuff by id
if ($stuffByID) {
    $stuff = $stuffByID;

    $lazymedia = implode(' ', array_map(function(array $v) use ($stuff): string {
        if ($v['type'] == 'image') {
            return sprintf('
                <a href="%2$s" class="imagepreview"><span class="lazycode">%1$s</span></a>
                ',
                jenc($v),
                $v['slug'],
                sprintf('stuff-%1$s', $stuff['id']),
            );
        }
        else if ($v['type'] == 'video' || $v['type'] == 'youtubeVideo') {
            return sprintf('
                <div class="videobox"><span class="lazycode">%1$s</span></div>
                ',
                jenc($v)
            );
        }
        else if ($v['type'] == 'audio') {
            return sprintf(
                '%2$s<br><span class="lazycode">%1$s</span>',
                jenc($v),
                basename($v['slug']),
            );
        }
        else {
            return sprintf(
                '<span class="lazycode">%1$s</span>',
                jenc($v)
            );
        }
    }, $stuff['media']));

    printf('
        <div class="box">
            <h2>%1$s</h2>
            %2$s
        </div>
        <div class="box">%3$s</div>
        ',
        $stuff['stuffName'],
        ($stuff['description']) ? sprintf('<p>%1$s</p>', $this->parseLazyInput($stuff['description'])) : '',
        ($lazymedia) ? $lazymedia : '',
    );


}




// stuff list
if ($stuffList) {
    printf('<div class="box%1$s">', ($stuffByID) ? ' more' : '');

    if ($stuffByID) {
        print('<h3>MORE STUFF ...</h3>');
    }

    print('<ul>');

    foreach ($stuffList as $v) {
        printf('
            <li><a href="%1$s"%3$s>%2$s</a></li>
            ',
            $this->routeURL(sprintf('stuff/id:%1$s', $v['id'])),
            $v['stuffName'],
            (isset($this->route['var']['id']) && $this->route['var']['id'] == $v['id']) ? ' class="active"' : '',
        );
    }

    print('</ul>');
    print('</div>');
}
