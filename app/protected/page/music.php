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
if ($releaseByID && $releaseByID['releasedOn']) {
    // prepare stuff
    $rls = $releaseByID;

    $bandcampBtn = '';
    if ($rls['bandcampSlug']) {
        $bandcampBtn = sprintf('<a href="%1$s" class="btn" title="Bandcamp"><img src="res/vendor/ico-bandcamp.svg"> %2$s</a>',
            $rls['bandcampHost'].$rls['bandcampSlug'].'?action=buy&from=embed',
            ($rls['freeToDownload']) ? 'FREE DOWNLOAD' : 'BUY',
        );
    }

    $spotifyBtn = '';
    if ($rls['spotifySlug']) {
        $spotifyBtn = sprintf('<a href="%1$s" class="btn" title="Spotify"><img src="res/vendor/ico-spotify.svg"> %2$s</a>',
            $rls['spotifyHost'].$rls['spotifySlug'],
            'STREAM',
        );
    }


    print('<div class="box release">');


    // cover image
    printf(
        '<p><a href="file/cover/%1$s-big.png" class="imagepreview"><img src="file/cover/%1$s-med.jpg" class="fluid"></a></p>',
        $rls['id'],
    );


    // rls heading
    printf('
        <h2>%s</h2>',
        $rls['releaseName']
    );


    // meta nfo
    print('<div class="meta">');
    print(implode(', ', array_filter([
        $rls['releaseType'],
        sprintf(ngettext('%s track', '%s tracks', $rls['trackCount']), $rls['trackCount']),
        (count($rls['artist']) > 1) ? 'Collaboration' : null,
        sprintf('Released %1$s', $rls['releasedOn']),
        ($rls['updatedOn']) ? sprintf('Updated %s', $rls['updatedOn']) : null,
        ($rls['labelName']) ? sprintf('Label %s', sprintf('<a href="%1$s">%2$s</a>', $rls['labelURL'], $rls['labelName'])) : null,
    ])));
    print('</div>');


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
            <span class="lazycode">{
                "type": "bandcamp%1$s",
                "slug": "%2$s",
                "trackCount": %3$s
            }</span>
            ',
            ($rls['trackCount'] > 1) ? 'Album' : 'Track',
            $rls['bandcampID'],
            $rls['trackCount'],
        );
    }


    // tracklist
    print('
        <table>
            <tbody>
        '
    );
    foreach ($rls['tracklist'] as $k => $v) {
        $artist = implode(', ', array_map(function(array $v): string {
            return $v['artistName'];
        }, $v['artist']));

        printf('
            <tr>
                <td>%1$s.</td>
                <td>%2$s</td>
                <td>%3$s</td>
                <td class="text-align-right">%4$s</td>
                <td class="text-align-center nobr">%5$s %6$s</td>
            </tr>
            ',
            $k+1,
            $artist,
            $v['audioName'],
            $v['audioRuntimeString'],
            ($v['bandcampSlug']) ? sprintf('<a href="%1$s%2$s"><img src="res/vendor/ico-bandcamp.svg" alt="%3$s on Bandcamp" title="%3$s on Bandcamp"></a>', $v['bandcampHost'], $v['bandcampSlug'], $v['audioName']) : '',
            ($v['spotifySlug']) ? sprintf('<a href="%1$s%2$s"><img src="res/vendor/ico-spotify.svg" alt="%3$s on Spotify" title="%3$s on Spotify"></a>', $v['spotifyHost'], $v['spotifySlug'], $v['audioName']) : '',
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
                if ($v['type'] == 'image') {
                    return sprintf('<a href="%1$s" class="imagepreview"><span class="lazycode">%2$s</span></a>', $v['slug'], jsonEncode($v));
                }
                else if ($v['type'] == 'video' || $v['type'] == 'youtubeVideo' || $v['type'] == 'youtubePlaylist') {
                    return sprintf('<div class="videobox"><span class="lazycode">%1$s</span></div>', jsonEncode($v));
                }
                else {
                    return sprintf('<span class="lazycode">%1$s</span>', jsonEncode($v));
                }
            }, $rls['relatedMedia']))
        );
        print('</div>'); // /.box
    }
}




// release list
if ($releaseList) {
    if ($releaseByID) {
        print('<div class="moreSpacer"></div>');
    }

    print('<div class="box">');

    if ($releaseByID) {
        printf('
            <h3>MORE MUSIC ...</h3>
            %1$s
            ',
            $releaseFilterHTML,
        );
    }

    print('<div class="grid simple">');

    foreach ($releaseList as $v) {

        if (!$v['releasedOn']) {
            continue;
        }

        printf('
            <div class="row text-align-center">
                <a href="%2$s"%8$s>
                    <img src="file/cover/%1$s-tn.jpg" alt="cover art" loading="lazy"><br>
                    %3$s
                </a><br>
                %4$s, %5$s, %6$s%7$s
            </div>
            ',
            $v['id'],
            $this->routeURL('music/id:%s', [$v['id']]),
            $v['releaseName'],
            $v['releaseType'],
            sprintf(ngettext('%s track', '%s tracks', $v['trackCount']), $v['trackCount']),
            (count($v['artist']) > 1) ? 'Collab, ' : '',
            ($v['updatedOn']) ? substr($v['updatedOn'], 0, 4) : substr($v['releasedOn'], 0, 4),
            (isset($this->route['var']['id']) && $this->route['var']['id'] == $v['id']) ? ' class="active"' : '',
        );
    }

    print('</div>');
    print('</div>');
}


printf('
    <div class="box">
        <p>
            You can also find my music on
            <a href="%1$s">Bandcamp</a>,
            <a href="%2$s">Spotify</a>,
            <a href="%3$s">Amazon</a>,
            <a href="%4$s">Apple</a>,
            <a href="%5$s">Deezer</a>,
            <a href="%6$s">YouTube</a>
            and many other music platforms. Just search for "SPARTALIEN" on your favorite one.
        </p>
        <p>
            If you decide to buy some of my music (thank you!), consider doing so on <a href="%1$s">Bandcamp</a>,
            since only there I can include bonus material and stuff for digital releases.
        </p>
    </div>',
    $this->conf['elsewhere']['bandcamp'][1],
    $this->conf['elsewhere']['spotify'][1],
    $this->conf['elsewhere']['amazon'][1],
    $this->conf['elsewhere']['apple'][1],
    $this->conf['elsewhere']['deezer'][1],
    $this->conf['elsewhere']['youtube'][1],
);
