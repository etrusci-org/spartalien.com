<?php
$archive = $this->getPlanet420('archive');
$session = $this->getPlanet420('session');
$artists = $this->getPlanet420('artists');
if ($session) {
    $session['tracklist'] = $this->getPlanet420('session-tracklist');
}
$hoursToListen = floor(array_sum(
    array_map(function(array $array) {
        return $array['sessionDur'];
    }, $archive)
) / 3600);



if (!$this->route['flag'] && !$this->route['var']) {
    printf('
        <div class="box">
            <h2>PLANET 420</h2>
            <p>
                Click the play button to listen to %1$s hours of selected eclectic music...
                or select individual sessions below.
            </p>
            <div data-lazymedia="mixcloud:playlist:/lowtechman/playlists/planet-420/">mixcloud:playlist:/lowtechman/playlists/planet-420/</div>
        </div>
        ',
        $hoursToListen,
    );
}


// session page
if ($session) {
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
        $session['sessionNum'],
        $session['trackCount'],
        $this->secondsToString($session['sessionDur']),
        $session['sessionDate'],
        ($session['mixcloudSlug']) ? sprintf('<a href="%1$s%2$s">%2$s</a>', $session['mixcloudHost'], $session['mixcloudSlug']) : 'Sorry, the recording for this one is lost.',
        ($session['mixcloudSlug']) ? sprintf('<div data-lazymedia="mixcloud:mix:%1$s">mixcloud:mix:%1$s</div>', $session['mixcloudSlug']) : '',
    );


    print('
        <table>
            <!--<thead>
                <tr>
                    <th class="text-align-right">start</th>
                    <th>artist</th>
                    <th>track</th>
                </tr>
            </thead>-->
            <tbody>
    ');


    foreach ($session['tracklist'] as $k => $v) {
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


    printf('
                </tbody>
            </table>
        </div>
    ');
}


// artists list
if ($artists) {
    printf('
        <div class="box">
            <h2>ARTISTS</h2>
            <p>Without these 523 artists, there would be no Planet 420. Happy crate digging!</p>
        </div>
        <div class="box">
        ',
        count($artists),
    );

    foreach ($artists as $v) {
        printf('
            <a href="//duckduckgo.com/?q=%2$s+artist">%1$s</a>
            ',
            $v['artistName'],
            urlencode($v['artistName']),
        );

        if (end($artists) != $v) {
            print(' | ');
        }
    }

    print('
        </div>
    ');
}



// mix archive listing
if ($archive) {
    // print('
    //     <div class="box">
    // ');

    if ($session) {
        print('
            <hr>
            <div class="box">
                <h3>MORE SESSIONS ...</h3>
        ');
    }
    else {
        print('
            <div class="box">
                <h3>SESSIONS</h3>
        ');
    }

    print('
        <table>
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th class="text-align-right">tracks</th>
                    <th class="text-align-right">runtime</th>
                    <th>date</th>
                </tr>
            </thead>
            <tbody>
        ');

    foreach ($archive as $v) {
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

    print('
                </tbody>
            </table>
        </div>
    ');


    // print('
    //     <div class="box">
    // ');

    // if (!$session) {
    //     print('<h3>SESSIONS</h3>');
    // }
    // else {
    //     print('<h3>MORE SESSIONS ...</h3>');
    // }

    // print('
    //     <div class="grid planet420-list">
    //         <div class="label">session</div>
    //         <div class="label">tracks</div>
    //         <div class="label text-align-right">runtime</div>
    //         <div class="label">date</div>
    //     ');

    // foreach ($archive as $v) {
    //     printf('
    //         <div><a href="%5$s"%6$s>Planet 420.%1$s</a></div>
    //         <div>%2$s</div>
    //         <div class="text-align-right">%3$s</div>
    //         <div>%4$s</div>
    //         ',
    //         $v['sessionNum'],
    //         $v['trackCount'],
    //         $this->secondsToString($v['sessionDur']),
    //         $v['sessionDate'],
    //         $this->routeURL(sprintf('planet420/session/num:%s', $v['sessionNum'])),
    //         (isset($this->route['var']['num']) && $this->route['var']['num'] == $v['sessionNum']) ? ' class="active"' : '',
    //     );
    // }

    // print('
    //         </ul>
    //     </div>
    // ');

    /*
    print('
        <div class="box">
    ');

    if ($session) {
        print('<h3>MORE SESSIONS ...</h3>');
    }

    print('
        <ul class="clean">
    ');

    foreach ($archive as $v) {
        printf('
            <li>
                <a href="%4$s"%5$s>Planet 420.%1$s</a> &middot;
                %2$s, %3$s
            </li>
            ',
            $v['sessionNum'],
            $this->secondsToString($v['sessionDur']),
            $v['sessionDate'],
            $this->routeURL(sprintf('planet420/session/num:%s', $v['sessionNum'])),
            (isset($this->route['var']['num']) && $this->route['var']['num'] == $v['sessionNum']) ? ' class="active"' : '',
        );
    }

    print('
            </ul>
        </div>
    ');
    */
}




// ???? route: planet420/session/id:N -> individual session page
// ???? route: planet420/artists -> individual artists list page
