<?php
// $track_list = [];
$track_list = $this->get_track_list();

$track = [];
if (isset($this->Router->route['var']['id'])) {
    $track = $this->get_track((int) $this->Router->route['var']['id']);
    // $track['artist_description'] = 'foo bar moo foo bar moo foo bar moo foo bar moo foo bar moo foo bar moo foo bar moo foo bar moo foo bar moo foo bar moo foo bar moo foo bar moo foo bar moo cow';
}

// var_dump($track_list);
?>


<section>

    <?php if (!$track) : ?>

        <h2>Tracks Catalog</h2>

    <?php else: ?>

        <h2>Track: <?php print($track['track_name']); ?></h2>

        <pre><?php print_r($track); ?></pre>

        </section>
        <section class="more">
            <h3>More Tracks ...</h3>

    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Track</th>
                <th>Artist</th>
                <th class="text-align-right">Runtime</th>
                <th class="text-align-right">DBID</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($track_list as $v) {
                printf('
                    <tr%6$s>
                        <td><a href="./catalog/id:%1$s">%2$s</a></td>
                        <td><a href="./artist/id:%4$s">%5$s</a></td>
                        <td class="text-align-right font-mono">%3$s</td>
                        <td class="text-align-right font-mono">%1$s</td>
                    </tr>',
                    $v['track_id'],
                    $v['track_name'],
                    $v['track_runtime_human'],
                    $v['artist_id'],
                    $v['artist_name'],
                    (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['track_id']) ? ' class="active"' : '',
                );
            }
            ?>
        </tbody>
    </table>

</section>
