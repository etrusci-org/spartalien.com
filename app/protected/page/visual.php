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




// visual not found, in case they follow old links
if (isset($this->route['var']['id']) && !$visualByID) {
    printf('
        <div class="box error">
            <p>The requested visual <code>[ID:%1$s]</code> does not exist or got assigned a new ID.</p>
            <img src="res/err404.gif" class="fluid">
        </div>',
        $this->route['var']['id'],
    );
}




// visual by id
if ($visualByID) {
    $lazymedia = array_map(function(string $v): string {
        return sprintf('<div data-lazymedia="%1$s">%1$s</div>', $v);
    }, $visualByID['media']);

    printf('
        <div class="box">
            <h2>%1$s</h2>
            <p>%2$s, %3$s</p>
            %4$s
        </div>
        ',
        $visualByID['visualName'],
        implode(' ', $visualByID['tags']),
        $visualByID['createdOn'],
        implode(' ', $lazymedia),
    );
}




// visual list
if ($visualList) {
    printf('<div class="box%1$s">', ($visualByID) ? ' more' : '');

    if ($visualByID) {
        print('<h3>MORE VISUALS ...</h3>');
    }

    print('<div class="grid visual-list">');

    foreach ($visualList as $v) {
        printf('
            <div class="row">
                <a href="%1$s"%6$s>
                    <img src="%2$s" alt="preview" loading="lazy"><br>
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








































/*
$visualList = $this->getVisual('list');
$visual = $this->getVisual('byID');


if (!$visual) {
    print('
        <div class="box">
            <h2>VISUALS FOR YOU, THEM, AND ME</h2>
        </div>
    ');
}


// visual not found, in case they follow old links
if (isset($this->route['var']['id']) && !$visual) {
    printf('
        <div class="box">
            The requested visual <code>[ID:%1$s]</code> does not exist or got assigned a new ID.
        </div>',
        $this->route['var']['id'],
    );
}


if ($visual) {
    $lazymedia = array();
    foreach ($visual['files'] as $v) {
        $type = null;
        $ext = pathinfo($v)['extension'];

        switch ($ext) {
            case 'png':
            case 'jpg':
            case 'gif':
                $type = 'image-lb';
                break;

            case 'mp4':
                $type = 'video-mp4';
                break;

            default:
                $type = 'none';
        }

        $lazymedia[] = sprintf('<div data-lazymedia="generic:%1$s:%2$s">generic:%1$s:%2$s</div>', $type, $v);
    }

    printf('
        <div class="box">
            <h2>%1$s</h2>
            <p>
                [ %2$s, %3$s ]
            </p>
            %4$s
        </div>
        <hr>
        ',
        $visual['visualName'],
        implode(' ', $visual['tags']),
        $visual['createdOn'],
        implode(' ', $lazymedia),
    );

}



// visual list
print('
    <div class="box">
');

if ($visual) {
    print('
        <h3>MORE VISUALS ...</h3>
    ');
}

print('
        <div class="grid visual-list">
');


foreach ($visualList as $v) {
    printf('
        <div class="row">
            <a href="%1$s"%6$s>
                <img src="%2$s" alt="preview" loading="lazy"><br>
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


print('
        </div>
    </div>
');
*/
