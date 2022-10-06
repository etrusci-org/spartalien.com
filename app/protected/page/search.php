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
                <input type="text" size="21" minlength="3" maxlength="30" name="query" placeholder="y o u r  q u e r y . . ." required autofocus>
                <input type="submit" name="search" value="search">
            </p>
        </form>',
        $this->routeURL('search'),
    );

    if (isset($_POST['search'])) {
        if (!$searchResult['query']) {
            print('<p class="error">You must enter a search term to make this work. Minimum 3 and maximum 30 characters.</p>');
        }
        else {
            printf('<p><code>%1$d</code> %2$s for <code>%3$s</code></p>',
                $searchResult['resultCountTotal'],
                ngettext('result', 'results', $searchResult['resultCountTotal']),
                (isset($_POST['query'])) ? trim($_POST['query']) : '',
            );
        }
    }

print('</div>');




if ($searchResult['resultCountTotal'] > 0) {
    $typeTitle = [
        'audioRelease' => 'MUSIC RELEASES',
        'audio' => 'MUSIC TRACKS',
        'visual' => 'VISUAL',
        'stuff' => 'STUFF',
        'news' => 'NEWS',
        'planet420' => 'PLANET 420 TRACK HISTORY',
    ];

    foreach ($searchResult['result'] as $type => $result) {
        print('<div class="box">');
        printf('<h3>%1$s</h3>', $typeTitle[$type]);
        print('<ul>');

        // audioRelease
        if ($type == 'audioRelease') {
            foreach ($result['items'] as $v) {
                printf('<li><a href="%1$s">%2$s</a> &middot; <span class="meta">%5$s &middot; %6$s %7$s</span></li>',
                    $this->routeURL('music/id:%s', [$v['id']]),
                    str_ireplace($searchResult['query'], sprintf('<span class="strmatch">%1$s</span>', $searchResult['query']), $v['releaseName']),
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
                printf('<li>%1$s &middot; <span class="meta">%3$s %4$s</span></li>',
                    str_ireplace($searchResult['query'], sprintf('<span class="strmatch">%1$s</span>', $searchResult['query']), $v['audioName']),
                    $v['bandcampID'],
                    ($v['bandcampSlug']) ? sprintf('<a href="%1$s%2$s"><img src="res/vendor/ico-bandcamp.svg" alt="%3$s on Bandcamp" title="%3$s on Bandcamp"></a>', $v['bandcampHost'], $v['bandcampSlug'], $v['audioName']) : '',
                    ($v['spotifySlug']) ? sprintf('<a href="%1$s%2$s"><img src="res/vendor/ico-spotify.svg" alt="%3$s on Spotify" title="%3$s on Spotify"></a>', $v['spotifyHost'], $v['spotifySlug'], $v['audioName']) : '',
                );
            }
        }

        // visual
        if ($type == 'visual') {
            foreach ($result['items'] as $v) {
                printf('<li><a href="%1$s">%2$s</a></li>',
                    $this->routeURL('visual/id:%s', [$v['id']]),
                    str_ireplace($searchResult['query'], sprintf('<span class="strmatch">%1$s</span>', $searchResult['query']), $v['visualName']),
                    sprintf('file/visual/%1$s-tn.jpg', $v['id']),
                );
            }
        }

        // stuff
        if ($type == 'stuff') {
            foreach ($result['items'] as $v) {
                printf('<li><a href="%1$s">%2$s</a></li>',
                    $this->routeURL('stuff/id:%s', [$v['id']]),
                    str_ireplace($searchResult['query'], sprintf('<span class="strmatch">%1$s</span>', $searchResult['query']), $v['stuffName']),
                );
            }
        }

        // news
        if ($type == 'news') {
            foreach ($result['items'] as $v) {
                $newsItems = array_map(function(string $v) use ($searchResult): string {

                    $v = $this->parseLazyInput($v);
                    $v = str_ireplace($searchResult['query'], sprintf('<span class="strmatch">%1$s</span>', $searchResult['query']), $v);
                    return $v;
                }, $v['items']);

                printf('<li><a href="%1$s">%2$s</a> &middot; %3$s</li>',
                    $this->routeURL('news/id:%s', [$v['id']]),
                    $v['postedOn'],
                    implode(' + ', $newsItems),
                );
            }
        }

        // planet420
        if ($type == 'planet420') {
            foreach ($result['items'] as $v) {
                printf('<li>%3$s - %4$s &middot; @%5$s in <a href="%2$s">Session #%1$s</a></li>',
                    $v['sessionNum'],
                    $this->routeURL('planet420/session/num:%s', [$v['sessionNum']]),
                    str_ireplace($searchResult['query'], sprintf('<span class="strmatch">%1$s</span>', $searchResult['query']), $v['artistName']),
                    str_ireplace($searchResult['query'], sprintf('<span class="strmatch">%1$s</span>', $searchResult['query']), $v['trackName']),
                    $this->secondsToString($v['timeStart']),
                );
            }
        }

        print('</ul>');
        print('</div>');
    }
}
