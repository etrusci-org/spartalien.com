<?php
$visualList = $this->getVisual('list');
$visualByID = $this->getVisual('byID');




// visual list index
if (!$visualByID) {
    print('
        <div class="box">
            <h2>VISUALS FOR YOU, THEM, AND ME</h2>
        </div>
    ');
}




// visual by id
if ($visualByID) {
    $vis = $visualByID;

    $lazymedia = implode(' ', array_map(function(array $v) use ($vis): string {
        if ($v['type'] == 'image') {
            return sprintf(
                '<a href="%2$s" class="imagepreview"><span class="lazycode">%1$s</span></a>',
                jsonEncode($v),
                $v['slug'],
                sprintf('visual-%1$s', $vis['id']),
            );
        }
        else {
            return sprintf(
                '<span class="lazycode">%1$s</span>',
                jsonEncode($v)
            );
        }
    }, $vis['media']));

    printf('
        <div class="box">
            <h2>%1$s</h2>
            <p class="meta">%2$s, %3$s</p>
            %4$s
        </div>
        <div class="box">
            %5$s
        </div>
        ',
        $vis['visualName'],
        implode(' ', $vis['tags']),
        $vis['createdOn'],
        ($vis['description']) ? sprintf('<p>%1$s</p>', $vis['description']) : '',
        $lazymedia,
    );
}




// visual list
if ($visualList) {
    if ($visualByID) {
        print('<div class="moreSpacer"></div>');
    }

    print('<div class="box">');

    if ($visualByID) {
        print('<h3>MORE VISUALS ...</h3>');
    }

    print('<div class="grid simple">');

    foreach ($visualList as $v) {
        printf('
            <div class="row text-align-center">
                <a href="%1$s"%6$s>
                    <img src="%2$s" alt="%3$s" loading="lazy"><br>
                    %3$s
                </a><br>
                %4$s, %5$s
            </div>
            ',
            $this->routeURL(sprintf('visual/id:%1$s', $v['id'])),
            sprintf('file/visual/%1$s-tn.jpg', $v['id']),
            $v['visualName'],
            implode(' ', $v['tags']),
            $v['createdOn'],
            (isset($this->route['var']['id']) && $this->route['var']['id'] == $v['id']) ? ' class="active"' : '',
        );
    }

    print('</div>');
    print('</div>');
}
