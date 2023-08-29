<?php
$session_list = $this->get_session_list();

$session = [];
if (isset($this->Router->route['var']['session'])) {
    $session = $this->get_session((int) $this->Router->route['var']['session']);
}

// var_dump($session_list);
?>


<section>

    <?php if (!$session) : ?>

        <h2>Planet 420</h2>
        <p>A series of 'special mixtapes' featuring curated tracks for each session, all tied together by a common theme awaiting your exploration.</p>
        <p>Music styles you can expect: Downtempo, IDM, Ambient, Lounge, Chillout, Experimental, NuJazz, Beats, Hip-Hop, and some more.</p>

    <?php else: ?>

        <h2>Session: <?php print($session['session_num']); ?></h2>

        <?php
        if ($session['session_mixcloud_url']) {
            printf('
                <div class="lazycode">
                    {"type": "mixcloudMix", "slug": "%1$s"}
                </div>',
                str_replace('//mixcloud.com', '', $session['session_mixcloud_url']),
            );
        }
        else {
            print('<p>Sorry, the recording for this one is lost.</p>');
        }
        ?>

        <pre><?php print_r($session); ?></pre>

        </section>
        <section class="more">
            <h3>More Sessions ...</h3>

    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Session</th>
                <th>Date</th>
                <th class="text-align-right">Tracks</th>
                <th class="text-align-right">Runtime</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($session_list as $v) {
                printf('
                    <tr>
                        <td><a href="./planet420/session:%1$s"%5$s>%1$s</a></td>
                        <td><a href="./planet420/session:%1$s"%5$s>%2$s</a></td>
                        <td class="text-align-right font-mono">%3$s</td>
                        <td class="text-align-right font-mono">%4$s</td>
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
