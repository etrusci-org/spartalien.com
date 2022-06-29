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
        printf('
            <div class="lazycode">{
                "type": "bandcamp%1$s",
                "slug": "%2$s",
                "trackCount": %3$s
            }</div>
            ',
            ($rls['trackCount'] > 1) ? 'Album' : 'Track',
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
            ($v['bandcampSlug']) ? sprintf('<a href="%1$s%2$s"><img src="res/ico-bandcamp.png" alt="Bandcamp" title="Bandcamp"></a>', $v['bandcampHost'], $v['bandcampSlug']) : '',
            ($v['spotifySlug']) ? sprintf('<a href="%1$s%2$s"><img src="res/ico-spotify.png" alt="Spotify" title="Spotify"></a>', $v['spotifyHost'], $v['spotifySlug']) : '',
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
        print(
            implode(' ', array_map(function(array $v): string {
                if ($v['type'] == 'video' || $v['type'] == 'youtubeVideo' || $v['type'] == 'youtubePlaylist') {
                    return sprintf('<div class="videobox"><div class="lazycode">%1$s</div></div>', jenc($v));
                }
                else {
                    return sprintf('<div class="lazycode">%1$s</div>', jenc($v));
                }
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

    // print('<div class="grid music-list">');
    print('<div class="grid simple">');

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
