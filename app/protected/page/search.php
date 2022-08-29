<?php
$searchResult = $this->getSearchResult();




printf('
    <div class="box">
        <h2>SEARCH</h2>
        <p>
            Query is case-insensitive.
            <code>rai</code> will find <code>rainbows</code> and <code>brain</code>.
        </p>

        <form action="%1$s" method="post">
            <p>
                <input type="text" size="21" minlength="3" maxlength="30" name="query" placeholder="y o u r  q u e r y . . ." required>
                <input type="submit" name="search" value="search">
            </p>
        </form>',
        $this->routeURL('search'),
    );

    if (isset($_POST['search'])) {
        printf('
            <p>
                <code>%1$d</code> %2$s for <code>%3$s</code>
            </p>',
            $searchResult['resultCountTotal'],
            ngettext('result', 'results', $searchResult['resultCountTotal']),
            (isset($_POST['query'])) ? trim($_POST['query']) : '',
        );
    }

print('</div>');




if ($searchResult['resultCountTotal'] > 0) {
    $typeTitle = array(
        'audioRelease' => 'MUSIC RELEASES',
        'audio' => 'MUSIC TRACKS',
        'visual' => 'VISUAL',
        'stuff' => 'STUFF',
        'news' => 'NEWS',
        'planet420' => 'PLANET 420 TRACK HISTORY',
    );

    foreach ($searchResult['result'] as $type => $result) {
        print('<div class="box">');
        printf('<h3>%1$s</h3>', $typeTitle[$type]);

        // audioRelease
        if ($type == 'audioRelease') {
            foreach ($result['items'] as $v) {
                printf('
                    <div>
                        <a href="%1$s">%2$s</a> &middot; <span class="meta">%5$s %6$s %7$s</span>
                        <span class="lazycode">{
                            "type": "bandcamp%3$s",
                            "slug": "%4$s"
                        }</span>
                    </div>',
                    $this->routeURL(sprintf('music/id:%1$s', $v['id'])),
                    $v['releaseName'],
                    ($v['trackCount'] > 1) ? 'Album' : 'Track',
                    $v['bandcampID'],
                    $v['releaseType'],
                    ($v['bandcampSlug']) ? sprintf('<a href="%1$s%2$s"><img src="res/vendor/ico-bandcamp.svg" alt="%3$s on Bandcamp" title="%3$s on Bandcamp"></a>', $v['bandcampHost'], $v['bandcampSlug'], $v['releaseName']) : '',
                    ($v['spotifySlug']) ? sprintf('<a href="%1$s%2$s"><img src="res/vendor/ico-spotify.svg" alt="%3$s on Spotify" title="%3$s on Spotify"></a>', $v['spotifyHost'], $v['spotifySlug'], $v['releaseName']) : '',
                );
            }
        }

        // audio
        if ($type == 'audio') {
            foreach ($result['items'] as $v) {
                printf('
                    <div>
                        %1$s &middot; <span class="meta">%3$s %4$s</span>
                        <span class="lazycode">{
                            "type": "bandcampTrack",
                            "slug": "%2$s"
                        }</span>
                    </div>',
                    $v['audioName'],
                    $v['bandcampID'],
                    ($v['bandcampSlug']) ? sprintf('<a href="%1$s%2$s"><img src="res/vendor/ico-bandcamp.svg" alt="%3$s on Bandcamp" title="%3$s on Bandcamp"></a>', $v['bandcampHost'], $v['bandcampSlug'], $v['audioName']) : '',
                    ($v['spotifySlug']) ? sprintf('<a href="%1$s%2$s"><img src="res/vendor/ico-spotify.svg" alt="%3$s on Spotify" title="%3$s on Spotify"></a>', $v['spotifyHost'], $v['spotifySlug'], $v['audioName']) : '',
                );
            }
        }

        // visual
        if ($type == 'visual') {
            print('<div class="grid simple">');
            foreach ($result['items'] as $v) {
                printf('
                    <div>
                        <a href="%1$s">%2$s<br>
                            <img src="%3$s" alt="%2$s" loading="lazy">
                        </a>
                    </div>',
                    $this->routeURL(sprintf('visual/id:%1$s', $v['id'])),
                    $v['visualName'],
                    sprintf('file/visual/%1$s-tn.jpg', $v['id']),
                );
            }
            print('</div>');
        }

        // stuff
        if ($type == 'stuff') {
            foreach ($result['items'] as $v) {
                printf('
                    <p>
                        <a href="%1$s">%2$s</a>
                    </p>',
                    $this->routeURL(sprintf('stuff/id:%1$s', $v['id'])),
                    $v['stuffName'],
                );
            }
        }

        // news
        if ($type == 'news') {
            foreach ($result['items'] as $v) {
                $newsItems = array_map(function(string $v): string {
                    return $this->parseLazyInput($v);
                }, $v['items']);

                printf('
                    <p>
                        <a href="%1$s">%2$s</a> &middot; %3$s
                    </p>',
                    $this->routeURL(sprintf('news/id:%1$s', $v['id'])),
                    $v['postedOn'],
                    implode(' + ', $newsItems),
                );
            }
        }

        // planet420
        if ($type == 'planet420') {
            foreach ($result['items'] as $v) {
                printf('
                    <p>
                        <a href="%2$s">%3$s - %4$s</a>
                        (@%5$s in session <a href="%2$s">#%1$s</a>)
                    </p>',
                    $v['sessionNum'],
                    $this->routeURL(sprintf('planet420/session/num:%1$s', $v['sessionNum'])),
                    $v['artistName'],
                    $v['trackName'],
                    $this->secondsToString($v['timeStart']),
                );
            }
        }

        print('</div>');
    }
}
