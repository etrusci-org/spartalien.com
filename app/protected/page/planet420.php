<?php
$sessionByID = $this->getPlanet420('sessionByID');
$artistsList = (!$sessionByID && in_array('artists', $this->route['flag'])) ? $this->getPlanet420('artistList') : null;
$archiveList = (!$artistsList) ? $this->getPlanet420('archiveList') : null;
if ($archiveList) {
    $hoursToListen = floor((array_sum(
        array_map(function(array $arr): int {
            return $arr['sessionDur'];
        }, $archiveList)
    ) - 10370 /* minus the first recording that was lost */) / 3600);
}
if ($sessionByID) {
    $sessionByID['tracklist'] = $this->getPlanet420('sessionTracklist');
}




// archive list index
if (!$artistsList && !$sessionByID) {
    printf('
        <div class="box">
            <h2>PLANET 420</h2>
            <p>These are my musical chillout sessions where I just enjoy some music from my personal collection...</p>
            <p>All sessions are <a href="%2$s">recorded live</a> and are then shortly afterwards available here and on <a href="//www.mixcloud.com/lowtechman/playlists/planet-420">Mixcloud</a>.</p>
            <p>Music styles you can expect: Downtempo, IDM, Ambient, Lounge, Chillout, Experimental, NuJazz, Beats, Hip-Hop, and <a href="%3$s">some more</a>.</p>
        </div>
        <div class="box">
            <p>New here? Then simply click the play button to listen to %1$s hours of selected eclectic music ...</p>
            <span class="lazycode">{
                "type": "mixcloudPlaylist",
                "slug": "/lowtechman/playlists/planet-420/"
            }</span>
        </div>
        ',
        $hoursToListen,
        $this->routeURL('cam'),
        $this->routeURL('planet420/artists'),
    );
}




// artists list
if ($artistsList) {
    printf('
        <div class="box">
            <h2>ARTISTS PLAYED SO FAR</h2>
            <p>Without these %1$s artists, there would be no Planet 420. Happy crate digging!</p>
        </div>
        <div class="box">
            %2$s
        </div>
        ',
        count($artistsList),
        implode(' / ', array_map(function(array $v): string {
            return sprintf('<a href="//duckduckgo.com/?q=%1$s+artist">%2$s</a>', urlencode($v['artistName']), $v['artistName']);
        }, $artistsList))
    );
}




// session by id
if ($sessionByID) {
    $s = $sessionByID;
    printf('
        <div class="box">
            <h2>Planet 420.%1$s</h2>
            <ul>
                <li><span class="label">Tracks:</span> %2$s</li>
                <li><span class="label">Runtime:</span> %3$s</li>
                <li><span class="label">Date:</span> %4$s</li>
                <li><span class="label">@Mixcloud:</span> %5$s</li>
            </ul>
            %6$s
        ',
        $s['sessionNum'],
        $s['trackCount'],
        $this->secondsToString($s['sessionDur']),
        $s['sessionDate'],
        ($s['mixcloudSlug']) ? sprintf('<a href="%1$s%2$s">%2$s</a>', $s['mixcloudHost'], $s['mixcloudSlug']) : 'Sorry, the recording for this one is lost.',
        ($s['mixcloudSlug']) ? sprintf('<span class="lazycode">{"type": "mixcloudMix", "slug": "%1$s"}</span>', $s['mixcloudSlug']) : '',
    );

    print('
        <table>
            <thead>
                <tr>
                    <th class="text-align-right">start</th>
                    <th>artist</th>
                    <th>track</th>
                </tr>
            </thead>
            <tbody>
    ');

    foreach ($s['tracklist'] as $k => $v) {
        printf('
            <tr>
                <td class="text-align-right">%1$s</td>
                <td><a href="//duckduckgo.com/?q=%4$s+artist">%2$s</a></td>
                <td><a href="//duckduckgo.com/?q=%5$s+song">%3$s</a></td>
            </tr>
        ',
        $this->secondsToString($v['timeStart']),
        $v['artistName'],
        $v['trackName'],
        urlencode($v['artistName']),
        urlencode(sprintf('%s - %s', $v['artistName'], $v['trackName'])),
       );
    }

    print('</tbody>');
    print('</table>');
    print('</div>');
}




// archive list
if ($archiveList) {
    // printf('<div class="box%1$s">', ($sessionByID) ? ' more' : '');

    if ($sessionByID) {
        print('<div class="moreSpacer"></div>');
    }

    print('<div class="box">');

    if (!$sessionByID) {
        print('<p>... or browse through individual sessions and their tracklists below &darr;</p>');
    }
    else {
        print('<h3>MORE SESSIONS ...</h3>');
    }

    print('
        <table>
            <thead>
                <tr>
                    <th>session</th>
                    <th class="text-align-right">tracks</th>
                    <th class="text-align-right">runtime</th>
                    <th>date</th>
                </tr>
            </thead>
            <tbody>
    ');

    foreach ($archiveList as $v) {
        printf('
            <tr>
                <td><a href="%5$s"%6$s>Planet 420.%1$s</a></td>
                <td class="text-align-right">%2$s</td>
                <td class="text-align-right">%3$s</td>
                <td>%4$s</td>
            </tr>
            ',
            $v['sessionNum'],
            $v['trackCount'],
            $this->secondsToString($v['sessionDur']),
            $v['sessionDate'],
            $this->routeURL(sprintf('planet420/session/num:%s', $v['sessionNum'])),
            (isset($this->route['var']['num']) && $this->route['var']['num'] == $v['sessionNum']) ? ' class="active"' : '',
        );
    }

    print('</tbody>');
    print('</table>');
    print('</div>');

    printf('
        <div class="box text-align-center">
            <a href="%1$s">click here for a complete list of artists played so far</a>
        </div>
        ',
        $this->routeURL('planet420/artists'),
    );
}
