<?php
$releaseList = $this->getAudio('list');
$releaseByID = $this->getAudio('byID');
$filter = $this->getAudioFilter();
$filterHTML = array();
foreach ($filter as $v) {
    $filterHTML[] = sprintf('<a href="%2$s"%3$s>%1$s</a>', $v[0], $v[1], $v[2] ? ' class="active"' : '');
}
$filterHTML = implode(' &middot; ', $filterHTML);


// header info
print('<h2>/audio</h2>');


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

    printf(
        '<h3>%s</h3>',
        hsc5($rls['releaseName']),
    );

    printf('
        <p>
            [
            %1$s
            %2$s
            &middot;
            released on %3$s%4$s
            ]
        </p>',
        $rls['releaseType'],
        ($collabArtist) ? sprintf('&middot; collab w/ %s', implode(' + ', $collabArtist)) : '',
        $rls['releasedOn'],
        ($rls['updatedOn']) ? sprintf(' &middot; updated on %s', $rls['updatedOn']) : '',
    );

    printf(
        '<p>%s</p>',
        $this->parseLazyInput($rls['description']),
    );

    print('TRACKLIST<ul>');
    $i = 1;
    foreach ($rls['tracklist'] as $v) {
        printf(
            '<li>%1$s. %2$s [%3$s]',
            $i++,
            hsc5($v['audioName']),
            $v['audioRuntimeString'],
        );
    }
    print('</ul>');

    printf(
        '<p>%1$s %2$s</p>',
        $bandcampBtn,
        $spotifyBtn,
    );

    printf(
        '<p><a href="file/cover/%1$s-big.png"><img src="file/cover/%1$s-med.jpg"></a></p>',
        $rls['id'],
    );

    // print('<hr><pre>');
    // print_r($releaseByID);
    // print('</pre>');

    print('<hr><h4>more...</h4>');
}


// release list
printf(
    '<p>%s</p>',
    $filterHTML,
);

print('
    <table>
        <thead>
            <tr>
                <th>title</th>
                <th>type</th>
                <th>date</th>
            </tr>
        </thead>
        <tbody>
');

foreach ($releaseList as $v) {
    $collabArtist = $this->getCollabArtist($v['artist']);

    printf('
        <tr>
            <td><a href="%1$s">%2$s</a>%3$s</td>
            <td>%4$s</td>
            <td>%5$s</td>
        </tr>',
        $this->routeURL(sprintf('audio/id:%s', $v['id'])),
        $v['releaseName'],
        ($collabArtist) ? sprintf(' [collab w/ %s]', implode(' + ', $collabArtist)) : '',
        $v['releaseType'],
        ($v['updatedOn']) ? $v['updatedOn'] : $v['releasedOn'],
    );
}

print('
        </tbody>
    </table>
');
