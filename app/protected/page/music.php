<?php
$releaseList = $this->getAudio('releaseList');
$releaseByID = $this->getAudio('releaseByID');
$releaseFilter = $this->getAudioFilter();
$releaseFilterHTML = implode(' ', array_map(function(array $v): string {
    return sprintf('<a href="%2$s" class="btn%3$s">%1$s</a>', $v[0], $v[1], ($v[2]) ? ' active' : '');
}, $releaseFilter));




// release list index
if (!$releaseByID) {
    printf('
        <div class="box">
            <h2>MUSIC FOR YOU, THEM, AND ME</h2>
            %1$s
        </div>
        ',
        $releaseFilterHTML,
    );
}




// release not found, in case they follow old links
if (isset($this->route['var']['id']) && !$releaseByID) {
    printf('
        <div class="box error">
            <p>The requested release <code>[ID:%1$s]</code> does not exist or got assigned a new ID.</p>
            <img src="res/err404.gif" class="fluid">
        </div>',
        $this->route['var']['id']
    );
}




// release by id
if ($releaseByID) {
    // prepare stuff
    $rls = $releaseByID;

    $platformBtnTpl = '<a href="%1$s" class="btn">%2$s</a>';

    $bandcampBtn = '';
    if ($rls['bandcampSlug']) {
        $bandcampBtn = sprintf($platformBtnTpl,
            $rls['bandcampHost'].$rls['bandcampSlug'].'?action=buy&from=embed',
            ($rls['freeToDownload']) ? 'FREE DOWNLOAD' : 'BUY',
        );
    }

    $spotifyBtn = '';
    if ($rls['spotifySlug']) {
        $spotifyBtn = sprintf($platformBtnTpl,
            $rls['spotifyHost'].$rls['spotifySlug'],
            'STREAM',
        );
    }


    print('<div class="box">');


    // rls heading
    printf('
        <h2>%s</h2>',
        $rls['releaseName']
    );


    // meta nfo
    printf('
        <p>
            %1$s &middot;
            %2$s &middot;
            %3$s
            Released %4$s
            %5$s
            %6$s
        </p>',
        $rls['releaseType'],
        sprintf(ngettext('%s track', '%s tracks', $rls['trackCount']), $rls['trackCount']),
        (count($rls['artist']) > 1) ? 'Collab &middot; ' : '',
        $rls['releasedOn'],
        ($rls['updatedOn']) ? sprintf('&middot; Updated %s', $rls['updatedOn']) : '',
        ($rls['labelName']) ? sprintf('&middot; Label %s', sprintf('<a href="%1$s">%2$s</a>', $rls['labelURL'], $rls['labelName'])) : '',
    );


    // cover image
    printf(
        '<p><a href="file/cover/%1$s-big.png"><img src="file/cover/%1$s-med.jpg" class="fluid"></a></p>',
        $rls['id'],
        // $this->conf['filesBasePath'],
    );


    // description
    printf(
        '<p>%s</p>',
        $this->parseLazyInput($rls['description']),
    );


    print('</div>'); // /.box
    print('<div class="box">');


    // buy/stream buttons
    printf(
        '<p class="text-align-center">%1$s %2$s</p>',
        $bandcampBtn,
        $spotifyBtn,
    );


    // bandcamp release player
    if ($rls['bandcampID']) {
        // printf('<div data-lazymedia="bandcamp:%1$s:%2$s:%3$s">bandcamp:%1$s:%2$s:%3$s</div>', ($rls['trackCount'] > 1) ? 'album' : 'track', $rls['bandcampID'], $rls['trackCount']);
        printf('
            <div class="lazymedia bandcamp %1$s">{
                "platform": "bandcamp",
                "type": "%1$s",
                "slug": "%2$s",
                "trackCount": "%3$s"
            }</div>
            ',
            ($rls['trackCount'] > 1) ? 'album' : 'track',
            $rls['bandcampID'],
            $rls['trackCount'],
        );
    }


    // tracklist
    print('<h3 class="text-align-center">TRACKLIST</h3>');
    print('
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>artist</th>
                    <th>track</th>
                    <th class="text-align-right">runtime</th>
                    <th class="text-align-center">&nearr;</th>
                </tr>
            </thead>
            <tbody>
        '
    );
    foreach ($rls['tracklist'] as $k => $v) {
        $artist = implode(', ', array_map(function(array $v): string {
            return $v['artistName'];
        }, $v['artist']));

        printf('
            <tr>
                <td>%1$s</td>
                <td>%2$s</td>
                <td>%3$s</td>
                <td class="text-align-right">%4$s</td>
                <td class="text-align-center">%5$s %6$s</td>
            </tr>
            ',
            $k+1,
            $artist,
            $v['audioName'],
            $v['audioRuntimeString'],
            ($v['bandcampSlug']) ? sprintf('<a href="%1$s%2$s"><img src="res/ico-bandcamp.png" alt="Bandcamp"></a>', $v['bandcampHost'], $v['bandcampSlug']) : '',
            ($v['spotifySlug']) ? sprintf('<a href="%1$s%2$s"><img src="res/ico-spotify.png" alt="Spotify"></a>', $v['spotifyHost'], $v['spotifySlug']) : '',
        );
    }
    print('
            </tbody>
        </table>
    ');


    print('</div>'); // /.box


    // credits
    if ($rls['credits']) {
        print('<div class="box">');
        print('<h3>CREDITS</h3>');
        print(
            sprintf(
                '<ul>%1$s</ul>',
                implode(' ', array_map(function(string $v): string {
                    return sprintf('<li>%s</li>', $v);
                }, $rls['credits'])),
            )
        );
        print('</div>'); // /.box
    }


    // thanks
    if ($rls['thanks']) {
        print('<div class="box">');
        print('<h3>THANKS</h3>');
        print(
            sprintf(
                '<ul>%1$s</ul>',
                implode(' ', array_map(function(string $v): string {
                    return sprintf('<li>%s</li>', $v);
                }, $rls['thanks'])),
            )
        );
        print('</div>'); // /.box
    }


    // related media
    if ($rls['relatedMedia']) {
        print('<div class="box">');
        print('<h3>RELATED MEDIA</h3>');
        // print(
        //     implode(' ', array_map(function(string $v): string {
        //         return sprintf('<div data-lazymedia="%1$s" class="gallery">%1$s</div>', $v);
        //     }, $rls['relatedMedia']))
        // );
        print(
            implode(' ', array_map(function(array $v): string {
                // var_dump(substr($v['slug'], 0, 4));
                // if (substr($v['slug'], 0, 4) != 'http' && substr($v['slug'], 0, 2) != '//') {
                    // $v['slug'] = $this->conf['filesBasePath'].$v['slug'];
                // }
                return sprintf('<div class="lazymedia">%1$s</div>', jenc($v));
            }, $rls['relatedMedia']))
        );
        print('</div>'); // /.box
    }

    // print('<pre>'); print_r($rls); print('</pre>');
}




// release list
if ($releaseList) {
    printf('<div class="box%1$s">', ($releaseByID) ? ' more' : '');

    if ($releaseByID) {
        print('<h3>MORE MUSIC ...</h3>');
    }

    print('<div class="grid music-list">');

    foreach ($releaseList as $v) {
        printf('
            <div class="row">
                <a href="%2$s"%8$s>
                    <img src="file/cover/%1$s-tn.jpg" alt="cover art" class="fluid" loading="lazy"><br>
                    %3$s
                </a><br>
                %4$s, %5$s, %6$s%7$s
            </div>
            ',
            $v['id'],
            $this->routeURL(sprintf('music/id:%s', $v['id'])),
            $v['releaseName'],
            $v['releaseType'],
            sprintf(ngettext('%s track', '%s tracks', $v['trackCount']), $v['trackCount']),
            (count($v['artist']) > 1) ? 'Collab, ' : '',
            ($v['updatedOn']) ? substr($v['updatedOn'], 0, 4) : substr($v['releasedOn'], 0, 4),
            (isset($this->route['var']['id']) && $this->route['var']['id'] == $v['id']) ? ' class="active"' : '',
            // $this->conf['filesBasePath'],
        );
    }

    print('</div>');
    print('</div>');
}
