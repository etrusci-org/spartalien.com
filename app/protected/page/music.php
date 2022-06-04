<?php
$releaseList = $this->getAudio('list');
$releaseByID = $this->getAudio('byID');
$filter = $this->getAudioFilter();
$filterHTML = array();
foreach ($filter as $v) {
    $filterHTML[] = sprintf('<a href="%2$s" class="btn%3$s">%1$s</a>', $v[0], $v[1], $v[2] ? ' active' : '');
}
// $filterHTML = implode(' &middot; ', $filterHTML);
$filterHTML = implode(' ', $filterHTML);


// main heading
if (!$releaseByID) {
    printf('
        <div class="box">
            <h2>MUSIC FOR YOU, THEM, AND ME</h2>
            %1$s
        </div>
        ',
        $filterHTML,
    );
}


// release by catalog id
if ($releaseByID) {
    $rls = $releaseByID;

    $collabArtist = $this->getCollabArtist($rls['artist']);

    $bandcampBtn = '';
    if ($rls['bandcampSlug']) {
        $bandcampBtn = sprintf(
            '<a href="%1$s" class="btn">%2$s</a>',
            $rls['bandcampHost'].$rls['bandcampSlug'],
            ($rls['freeToDownload']) ? 'FREE DOWNLOAD' : 'BUY',
        );
    }

    $spotifyBtn = '';
    if ($rls['spotifySlug']) {
        $spotifyBtn = sprintf(
            '<a href="%1$s" class="btn">STREAM</a>',
            $rls['spotifyHost'].$rls['spotifySlug'],
        );
    }

    // rls heading
    printf(
        '
        <div class="box">
            <h2>%s</h2>
        ',
        hsc5($rls['releaseName']),
    );

    // meta nfo
    printf('
        <p>
            [
            %1$s
            %2$s
            &middot;
            released %3$s%4$s
            %5$s
            ]
        </p>',
        $rls['releaseType'],
        ($collabArtist) ? sprintf('&middot; collab w/ %s', implode(' + ', $collabArtist)) : '',
        $rls['releasedOn'],
        ($rls['updatedOn']) ? sprintf(' &middot; updated on %s', $rls['updatedOn']) : '',
        ($rls['labelName']) ? sprintf('&middot; on label %s', $rls['labelName']) : '',

    );

    // description
    printf(
        '<p>%s</p>',
        $this->parseLazyInput($rls['description']),
    );

    // credits
    if ($rls['credits']) {
        print('CREDITS<br>');
        $credits = array();
        foreach ($rls['credits'] as $v) {
            $credits[] = sprintf('<li>%s</li>', hsc5($v));
        }
        $credits = sprintf('<ul>%s</ul>', implode('', $credits));
        print($credits);
    }

    // credits
    if ($rls['thanks']) {
        print('THANKS<br>');
        $thanks = array();
        foreach ($rls['thanks'] as $v) {
            $thanks[] = sprintf('<li>%s</li>', hsc5($v));
        }
        $thanks = sprintf('<ul>%s</ul>', implode('', $thanks));
        print($thanks);
    }

    // bandcamp player
    if ($rls['bandcampID']) {
        print('BANDCAMP PLAYER<br>');
        printf('<div data-lazymedia="bandcamp:%1$s:%2$s">bandcamp:%1$s:%2$s</div>', ((count($rls['tracklist']) > 1) ? 'album' : 'track'), $rls['bandcampID']);
    }

    // tracklist
    print('TRACKLIST');
    $i = 1;
    $tracklist = array();
    foreach ($rls['tracklist'] as $v) {
        $tracklist[] = sprintf(
            '<li>%1$s. %2$s [%3$s] %4$s %5$s',
            $i++,
            hsc5($v['audioName']),
            $v['audioRuntimeString'],
            ($v['bandcampURL']) ? sprintf('(<a href="%s">B</a>)', $v['bandcampURL']) : '',
            ($v['spotifyURL']) ? sprintf('(<a href="%s">S</a>)', $v['spotifyURL']) : '',
        );
    }
    printf('<ul>%s</ul>', implode('', $tracklist));

    // related media
    if ($rls['relatedMedia']) {
        print('RELATED MEDIA<br>');
        $relatedMedia = array();
        foreach ($rls['relatedMedia'] as $v) {
            $relatedMedia[] = sprintf('<div data-lazymedia="%1$s">%1$s</div>', $v);
        }
        $relatedMedia = implode('', $relatedMedia);
        print($relatedMedia);
    }

    // buy/stream buttons
    printf(
        '<p>%1$s %2$s</p>',
        $bandcampBtn,
        $spotifyBtn,
    );

    // cover image
    printf(
        '<p><a href="file/cover/%1$s-big.png"><img src="file/cover/%1$s-med.jpg"></a></p>',
        $rls['id'],
    );

    // print('<hr><pre>');
    // print_r($releaseByID);
    // print('</pre>');

    print('</div>');
}


// release not found, in case they follow old links
if (isset($this->route['var']['id']) && !$releaseByID) {
    printf('
        <div class="box">
            The requested release <code>[ID:%1$s]</code> does not exist or got assigned a new ID.
        </div>',
        $this->route['var']['id']
    );
}


// release list
print('<div class="box">');

if ($releaseByID) {
    printf('
            <h3>MORE MUSIC ...</h3>
            %1$s
            <hr>
        ',
        $filterHTML,
    );
}

print('
    <table>
        <!--
        <thead>
            <tr>
                <th>title</th>
                <th>type</th>
                <th>date</th>
            </tr>
        </thead>
        -->
        <tbody>
');

foreach ($releaseList as $v) {
    $collabArtist = $this->getCollabArtist($v['artist']);

    printf('
        <tr>
            <td><a href="%1$s"%6$s>%2$s</a>%3$s</td>
            <td>%4$s</td>
            <td>%5$s</td>
        </tr>',
        $this->routeURL(sprintf('music/id:%s', $v['id'])),
        $v['releaseName'],
        ($collabArtist) ? sprintf(' [collab w/ %s]', implode(' + ', $collabArtist)) : '',
        $v['releaseType'],
        ($v['updatedOn']) ? $v['updatedOn'] : $v['releasedOn'],
        (isset($this->route['var']['id']) && $this->route['var']['id'] == $v['id']) ? ' class="active"' : '',
    );
}

print('
            </tbody>
        </table>
    </div>
');












/*
$releaseList = $this->getAudio('list');
$releaseByID = $this->getAudio('byID');
$filter = $this->getAudioFilter();
$filterHTML = array();
foreach ($filter as $v) {
    $filterHTML[] = sprintf('<a href="%2$s"%3$s>%1$s</a>', $v[0], $v[1], $v[2] ? ' class="active"' : '');
}
$filterHTML = implode(' &middot; ', $filterHTML);


// header info
print('
    <div class="box">
        <h2>MUSIC</h2>'
);

// release filter
printf(
    '<p>%s</p>',
    $filterHTML,
);

print('</div>');


// release by catalog id
if ($releaseByID) {
    $rls = $releaseByID;

    $collabArtist = $this->getCollabArtist($rls['artist']);

    $bandcampBtn = '';
    if ($rls['bandcampSlug']) {
        $bandcampBtn = sprintf(
            '<a href="%1$s" class="btn">%2$s</a>',
            $rls['bandcampHost'].$rls['bandcampSlug'],
            ($rls['freeToDownload']) ? 'FREE DOWNLOAD' : 'BUY',
        );
    }

    $spotifyBtn = '';
    if ($rls['spotifySlug']) {
        $spotifyBtn = sprintf(
            '<a href="%1$s" class="btn">STREAM</a>',
            $rls['spotifyHost'].$rls['spotifySlug'],
        );
    }

    // heading
    printf(
        '<h3>%s</h3>',
        hsc5($rls['releaseName']),
    );

    // meta nfo
    printf('
        <p>
            [
            %1$s
            %2$s
            &middot;
            released %3$s%4$s
            %5$s
            ]
        </p>',
        $rls['releaseType'],
        ($collabArtist) ? sprintf('&middot; collab w/ %s', implode(' + ', $collabArtist)) : '',
        $rls['releasedOn'],
        ($rls['updatedOn']) ? sprintf(' &middot; updated on %s', $rls['updatedOn']) : '',
        ($rls['labelName']) ? sprintf('&middot; on label %s', $rls['labelName']) : '',

    );

    // description
    printf(
        '<p>%s</p>',
        $this->parseLazyInput($rls['description']),
    );

    // credits
    if ($rls['credits']) {
        print('CREDITS<br>');
        $credits = array();
        foreach ($rls['credits'] as $v) {
            $credits[] = sprintf('<li>%s</li>', hsc5($v));
        }
        $credits = sprintf('<ul>%s</ul>', implode('', $credits));
        print($credits);
    }

    // credits
    if ($rls['thanks']) {
        print('THANKS<br>');
        $thanks = array();
        foreach ($rls['thanks'] as $v) {
            $thanks[] = sprintf('<li>%s</li>', hsc5($v));
        }
        $thanks = sprintf('<ul>%s</ul>', implode('', $thanks));
        print($thanks);
    }

    // bandcamp player
    if ($rls['bandcampID']) {
        print('BANDCAMP PLAYER<br>');
        printf('<div data-lazymedia="bandcamp:%1$s:%2$s">bandcamp:%1$s:%2$s</div>', ((count($rls['tracklist']) > 1) ? 'album' : 'track'), $rls['bandcampID']);
    }

    // tracklist
    print('TRACKLIST');
    $i = 1;
    $tracklist = array();
    foreach ($rls['tracklist'] as $v) {
        $tracklist[] = sprintf(
            '<li>%1$s. %2$s [%3$s] %4$s %5$s',
            $i++,
            hsc5($v['audioName']),
            $v['audioRuntimeString'],
            ($v['bandcampURL']) ? sprintf('(<a href="%s">B</a>)', $v['bandcampURL']) : '',
            ($v['spotifyURL']) ? sprintf('(<a href="%s">S</a>)', $v['spotifyURL']) : '',
        );
    }
    printf('<ul>%s</ul>', implode('', $tracklist));

    // related media
    if ($rls['relatedMedia']) {
        print('RELATED MEDIA<br>');
        $relatedMedia = array();
        foreach ($rls['relatedMedia'] as $v) {
            $relatedMedia[] = sprintf('<div data-lazymedia="%1$s">%1$s</div>', $v);
        }
        $relatedMedia = implode('', $relatedMedia);
        print($relatedMedia);
    }

    // buy/stream buttons
    printf(
        '<p>%1$s %2$s</p>',
        $bandcampBtn,
        $spotifyBtn,
    );

    // cover image
    printf(
        '<p><a href="file/cover/%1$s-big.png"><img src="file/cover/%1$s-med.jpg"></a></p>',
        $rls['id'],
    );

    // print('<hr><pre>');
    // print_r($releaseByID);
    // print('</pre>');

    print('<hr><h4>more...</h4>');
}


// // release filter
// printf(
//     '<p>%s</p>',
//     $filterHTML,
// );


// release list
print('
    <div class="box">
        <table>
            <!--
            <thead>
                <tr>
                    <th>title</th>
                    <th>type</th>
                    <th>date</th>
                </tr>
            </thead>
            -->
            <tbody>
');

foreach ($releaseList as $v) {
    $collabArtist = $this->getCollabArtist($v['artist']);

    printf('
        <tr>
            <td><a href="%1$s"%6$s>%2$s</a>%3$s</td>
            <td>%4$s</td>
            <td>%5$s</td>
        </tr>',
        $this->routeURL(sprintf('music/id:%s', $v['id'])),
        $v['releaseName'],
        ($collabArtist) ? sprintf(' [collab w/ %s]', implode(' + ', $collabArtist)) : '',
        $v['releaseType'],
        ($v['updatedOn']) ? $v['updatedOn'] : $v['releasedOn'],
        (isset($this->route['var']['id']) && $this->route['var']['id'] == $v['id']) ? ' class="active"' : '',
    );
}

print('
            </tbody>
        </table>
    </div>
');
*/
