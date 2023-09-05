<?php
$track_list = $this->get_catalog_track_list();

$track = [];
if (isset($this->Router->route['var']['track'])) {
    $track = $this->get_track((int) $this->Router->route['var']['track']);
}

$artist = [];
if (isset($this->Router->route['var']['artist'])) {
    $artist = $this->get_artist((int) $this->Router->route['var']['artist']);
}
?>





<?php if ($track): ?>
    <h2><?php print($track['track_name']); ?></h2>

    <?php
    // player
    printf('
        <div class="box">
            <div class="lazycode">{
                "type": "bandcamptrack",
                "slug": "%1$s"
            }</div>
        </div>',
        $track['track_bandcamp_id'],
    );
    ?>


    <div class="grid-x-2">
        <?php
        // meta + description
        printf('
            <div class="box">
                <h3>Meta</h3>
                <ul class="meta">
                    <li>Artist: <a href="./catalog/artist:%1$s">%2$s</a></li>
                    <li>Runtime: %3$s [%4$ss]</li>
                </ul>
            </div>',
            $track['artist_id'],
            $track['artist_name'],
            $track['track_runtime_human'],
            $track['track_runtime'],
        );


        // credit
        if ($track['track_credit']) {
            printf(
                '<div class="box">
                    <h3>Credits / Notes</h3>
                    %1$s
                </div>',
                implode('', array_map(fn(string $v): string => sprintf('<p>%1$s</p>', $this->_lazytext($v)), $track['track_credit']))
            );
        }
        ?>
    </div>

    <?php
    // dist
    printf('
        <div class="box">
            <h3>Distribution</h3>
            <ul>
                %1$s
            </ul>
        </div>',
        implode('', array_map(fn(array $v): string => sprintf('<li><a href="%1$s">%2$s</a></li>', $v['url'], ucwords($v['platform'])), $track['track_dist'])),
    );
    ?>

    <p>
        <a href="javascript:history.back(-1);">&lArr; back</a>
    </p>

    <!-- <?php var_dump($track); ?> -->
<?php endif ?>





<?php if ($artist): ?>
    <h2><?php print($artist['artist_name']); ?></h2>

    <?php
    // meta
    $meta = '';
    if ($artist['artist_description']) $meta .= $this->_lazytext($artist['artist_description']);
    if ($artist['artist_url']) $meta .= sprintf('<p class="meta"><a href="%1$s">%1$s</a></p>', $artist['artist_url']);
    if (!$meta) $meta = '<p>No information.</p>';
    printf(
        '<div class="box">
            <h3>Meta</h3>
            %1$s
        </div>',
        $meta,
    );
    ?>

    <p>
        <a href="javascript:history.back(-1);">&lArr; back</a>
    </p>
    <!-- <?php var_dump($artist); ?> -->
<?php endif ?>






<?php if (!$artist): ?>

    <div <?php print(($track) ? 'class="more"' : ''); ?>>
        <h2><?php print((!$track) ? 'Tracks Catalog' : 'More Tracks ...'); ?></h2>

        <!-- <?php var_dump($track_list); ?> -->
        <div class="box">
            <table>
                <thead>
                    <tr>
                        <th>Track</th>
                        <th>Artist</th>
                        <th>Runtime</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($track_list as $v) {
                        printf('
                            <tr>
                                <td><a href="./catalog/track:%1$s"%6$s>%2$s</a></td>
                                <td><a href="./catalog/artist:%4$s">%5$s</a></td>
                                <td class="text-align-right font-mono">%3$s</td>
                            </tr>',
                            $v['track_id'],
                            $v['track_name'],
                            $v['track_runtime_human'],
                            $v['artist_id'],
                            $v['artist_name'],
                            (isset($this->Router->route['var']['track']) && $this->Router->route['var']['track'] == $v['track_id']) ? ' class="active"' : '',
                        );
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
<?php endif; ?>



































<?php
/*
// $track_list = [];
$track_list = $this->get_catalog_track_list();

$track = [];
if (isset($this->Router->route['var']['track'])) {
    $track = $this->get_track((int) $this->Router->route['var']['track']);
}


$artist = [];
if (isset($this->Router->route['var']['artist'])) {
    $artist = $this->get_artist((int) $this->Router->route['var']['artist']);
}

// var_dump($track_list);
?>


<?php if ($track): ?>
    <section>
        <h2>Track: <?php print($track['track_name']); ?></h2>

        <pre><?php print_r($track); ?></pre>
    </section>
<?php endif; ?>


<?php if ($artist): ?>
    <section>
        <h2>Artist: <?php print($artist['artist_name']); ?></h2>

        <pre><?php print_r($artist); ?></pre>
    </section>
<?php endif; ?>


<section <?php print(($track || $artist) ? 'class="more"' : ''); ?>>
    <?php print((!$track && !$artist) ? '<h2>Tracks Catalog</h2>' : '<h3>More Tracks ...</h3>'); ?>

    <table>
        <thead>
            <tr>
                <th>Track</th>
                <th>Artist</th>
                <th class="text-align-right">Runtime</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($track_list as $v) {
                printf('
                    <tr>
                        <td><a href="./catalog/track:%1$s"%6$s>%2$s</a></td>
                        <td><a href="./catalog/artist:%4$s">%5$s</a></td>
                        <td class="text-align-right font-mono">%3$s</td>
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
*/
