<?php
$session_list = $this->get_session_list();

$session = [];
if (isset($this->Router->route['var']['session'])) {
    $session = $this->get_session((int) $this->Router->route['var']['session']);
}

$total_hours_to_listen = $this->get_total_hours_to_listen($session_list);
?>




<?php if ($session): ?>
    <h2>Planet 420.<?php print($session['session_num']); ?></h2>

    <div class="grid-x-2">
        <?php
        if ($session['session_mixcloud_key']) {
            printf(
                '<div class="box full-width">
                    <div class="lazycode">
                        {"type": "mixcloudshow", "slug": "%1$s"}
                    </div>
                </div>',
                $session['session_mixcloud_key'],
            );
        }
        else {
            print('<p>Sorry, the recording for this one is lost.</p>');
        }
        ?>

        <?php
        printf('
            <div class="box">
                <h3>Meta</h3>
                <ul class="meta">
                    <li>Track count: %1$s</li>
                    <li>Total runtime: %2$s</li>
                    <li>Released: %3$s</li>
                </ul>
            </div>',
            $session['session_track_count'],
            $session['session_runtime_human'],
            $session['session_pub_date'],
        );
        ?>
    </div>

    <p>
        <input type="text" class="elfilter-input" placeholder="Filter tracklist..." title="'uni' will find 'unicorns' and 'reunion'">
    </p>

    <div class="box">
        <h3>Tracklist</h3>
        <table class="elfilter">
            <thead>
                <tr>
                    <th>Start Time</th>
                    <th>Artist</th>
                    <th>Track</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($session['session_track_list'] as $v) {
                    printf(
                        '<tr>
                            <td>%1$s</td>
                            <td>%2$s</td>
                            <td>%3$s</td>
                        </tr>',
                        $v['track_start_time_human'],
                        $this->_hsc($v['artist_name']),
                        $this->_hsc($v['track_name']),
                    );
                }
                ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>




<div <?php print(($session) ? 'class="more"' : ''); ?>>
    <h2><?php print((!$session) ? 'Planet 420' : 'More Sessions ...'); ?></h2>
    <?php if (!$session): ?>

        <div class="box">
            <p>A series of 'special mixtapes' featuring carefully selected tracks for each session, all tied together by a common thread awaiting your exploration.</p>
            <p>Music styles you can expect: Downtempo, IDM, Ambient, Lounge, Chillout, Experimental, NuJazz, Beats, Hip-Hop, and some more.</p>
        </div>

        <div class="box full-width">
            <p>
                New here? Then simply click the play button to listen to (so far)
                <?php print($total_hours_to_listen); ?>
                hours of selected eclectic music...
            </p>
            <div class="lazycode">{
                "type": "mixcloudplaylist",
                "slug": "lowtechman/playlists/planet-420"
            }</div>
            <p>
                ...or find your favorite session in the archive below &dArr;
            </p>
        </div>
    <?php endif; ?>

    <div class="box">
        <h3>Session Archive</h3>
        <table>
            <thead>
                <tr>
                    <th>Session</th>
                    <th>Runtime</th>
                    <th>Tracks</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($session_list as $v) {
                    printf('
                        <tr>
                            <td><a href="./planet420/session:%1$s"%5$s>Planet 420.%1$s / %2$s</a></td>
                            <td class="text-align-right">%3$s</td>
                            <td class="text-align-right">%4$s</td>
                        </tr>',
                        $v['session_num'],
                        $v['session_pub_date'],
                        $v['session_runtime_human'],
                        $v['session_track_count'],
                        (isset($this->Router->route['var']['session']) && $this->Router->route['var']['session'] == $v['session_num']) ? ' class="active"' : '',
                    );
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
