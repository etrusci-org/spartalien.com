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


    print('<div class="meta">');
        // meta nfo
        print(implode(', ', array_filter(array(
            $rls['releaseType'],
            sprintf(ngettext('%s track', '%s tracks', $rls['trackCount']), $rls['trackCount']),
            (count($rls['artist']) > 1) ? 'Collaboration' : null,
            sprintf('Released %1$s', $rls['releasedOn']),
            ($rls['updatedOn']) ? sprintf('Updated %s', $rls['updatedOn']) : null,
            ($rls['labelName']) ? sprintf('Label %s', sprintf('<a href="%1$s">%2$s</a>', $rls['labelURL'], $rls['labelName'])) : null,
        ))));
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
                "slug": "%2$s"
            }</span>
            ',
            ($rls['trackCount'] > 1) ? 'Album' : 'Track',
            $rls['bandcampID'],
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
            ($v['bandcampSlug']) ? sprintf('<a href="%1$s%2$s"><img src="res/vendor/ico-bandcamp.svg" alt="Bandcamp" title="This track on Bandcamp"></a>', $v['bandcampHost'], $v['bandcampSlug']) : '',
            ($v['spotifySlug']) ? sprintf('<a href="%1$s%2$s"><img src="res/vendor/ico-spotify.svg" alt="Spotify" title="This track on Spotify"></a>', $v['spotifyHost'], $v['spotifySlug']) : '',
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

    // print('<pre>'); print_r($rls); print('</pre>');
}




// release list
if ($releaseList) {
    if ($releaseByID) {
        print('<div class="moreSpacer"></div>');
    }

    print('<div class="box">');

    if ($releaseByID) {
        print('<h3>MORE MUSIC ...</h3>');
    }

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
        );
    }

    print('</div>');
    print('</div>');
}


print('
    <div class="box">
        <p>
            You can also find my music on
            <a href="https://spartalien.bandcamp.com">Bandcamp</a>,
            <a href="https://open.spotify.com/artist/553FKlcVkf1YFU6dl129Ef">Spotify</a>,
            <a href="https://music.amazon.com/artists/B07FYWLY7Z">Amazon</a>,
            <a href="https://music.apple.com/artist/spartalien/1455263028">Apple</a>,
            <a href="https://www.deezer.com/artist/50523232">Deezer</a>,
            <a href="https://www.youtube.com/channel/UCXwYExlRqK_oeUocuKkhRUw">YouTube</a>
            and many other music platforms. Just search for "SPARTALIEN".
        </p>
        <p>
            If you decide to buy some of my music (thank you!), consider doing so on <a href="https://spartalien.bandcamp.com">Bandcamp</a>,
            since only there I can include bonus material and stuff for digital releases.
        </p>
    </div>');
