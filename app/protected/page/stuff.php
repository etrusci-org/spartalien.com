<?php
$stuffList = $this->getStuff('list');
$stuffByID = $this->getStuff('byID');




// stuff by id
if ($stuffByID) {
    $stuff = $stuffByID;

    $lazymedia = implode(' ', array_map(function(array $v) use ($stuff): string {
        if ($v['type'] == 'image') {
            return sprintf(
                '<a href="%2$s" data-lightbox="%3$s"><div class="lazymedia">%1$s</div></a>',
                jenc($v),
                $v['slug'],
                sprintf('stuff-%1$s', $stuff['id']),
            );
        }
        else {
            return sprintf(
                '<div class="lazymedia">%1$s</div>',
                jenc($v)
            );
        }
    }, $stuff['media']));

    printf('
        <div class="box">
            <h2>%1$s</h2>
            %2$s
        </div>
        %3$s
        ',
        $stuff['stuffName'],
        ($stuff['description']) ? sprintf('<p>%1$s</p>', $this->parseLazyInput($stuff['description'])) : '',
        ($lazymedia) ? sprintf('<div class="box">%1$s</div>', $lazymedia) : '',
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
        printf(
            '<li><a href="%1$s"%3$s>%2$s</a></li>',
            $this->routeURL(sprintf('stuff/id:%1$s', $v['id'])),
            $v['stuffName'],
            (isset($this->route['var']['id']) && $this->route['var']['id'] == $v['id']) ? ' class="active"' : '',
        );
    }

    print('</div>');
    print('</div>');
}
