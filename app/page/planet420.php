<?php
$session_list = $this->get_session_list();

$session = [];
if (isset($this->Router->route['var']['session'])) {
    $session = $this->get_session((int) $this->Router->route['var']['session']);
}

// $artist_list = [];
// if (isset($this->Router->route['var']['list']) && $this->Router->route['var']['list'] == 'artist') {
//     // $artist = $this->get_artist_list();
//     $artist_list = [];
// }

// $track_list = [];
// if (isset($this->Router->route['var']['list']) && $this->Router->route['var']['list'] == 'track') {
//     // $track = $this->get_track_list();
//     $track_list = [];
// }


// var_dump($session_list);
// var_dump($session);
// var_dump($artist_list);
// var_dump($track_list);
?>


<?php if ($session): ?>
    <section>
        <h2>Planet 420.<?php print($session['session_num']); ?></h2>

        <?php
        if ($session['session_mixcloud_key']) {
            printf('
                <div class="lazycode">
                    {"type": "mixcloudMix", "slug": "%1$s"}
                </div>',
                $session['session_mixcloud_key'],
            );
        }
        else {
            print('<p>Sorry, the recording for this one is lost.</p>');
        }
        ?>

        <pre><?php print_r($session); ?></pre>
    </section>
<?php endif; ?>


<section <?php print(($session) ? 'class="more"' : ''); ?>>
    <?php print((!$session) ? '<h2>Planet 420</h2>' : '<h3>More Sessions  ...</h3>'); ?>

    <?php if (!$session): ?>
        <p>A series of 'special mixtapes' featuring curated tracks for each session, all tied together by a common theme awaiting your exploration.</p>
        <p>Music styles you can expect: Downtempo, IDM, Ambient, Lounge, Chillout, Experimental, NuJazz, Beats, Hip-Hop, and some more.</p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Session</th>
                <th>Date</th>
                <th class="text-align-right">Runtime</th>
                <th>Tracks</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($session_list as $v) {
                printf('
                    <tr>
                        <td><a href="./planet420/session:%1$s"%5$s>%1$s</a></td>
                        <td><a href="./planet420/session:%1$s"%5$s>%2$s</a></td>
                        <td class="text-align-right font-mono">%4$s</td>
                        <td>%3$s</td>
                    </tr>',
                    $v['session_num'],
                    $v['session_pub_date'],
                    $v['session_track_count'],
                    $v['session_runtime_human'],
                    (isset($this->Router->route['var']['session']) && $this->Router->route['var']['session'] == $v['session_num']) ? ' class="active"' : '',
                );
            }
            ?>
        </tbody>
    </table>
</section>
