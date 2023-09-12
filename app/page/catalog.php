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
    <h2>
        <?php
        printf(
            '%1$s%2$s',
            ($track['artist_id'] != 1) ? sprintf('%s - ', $track['artist_name']) : '',
            $track['track_name'],
        );
        ?>
    </h2>


    <?php
    printf('
        <div class="box full-width">
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
        printf('
            <div class="box">
                <h3>Meta</h3>
                <ul class="meta">
                    <li>Type: Track</li>
                    <li>Artist: <a href="./catalog/artist:%1$s">%2$s</a></li>
                    <li>Runtime: %3$s</li>
                </ul>
            </div>',
            $track['artist_id'],
            $track['artist_name'],
            $track['track_runtime_human'],
        );

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
<?php endif ?>





<?php if ($artist): ?>
    <h2><?php print($artist['artist_name']); ?></h2>
    <div class="box">
        <?php
        printf('
            <h3>Meta</h3>
            <ul class="meta">
                <li>Type: Artist</li>
                %1$s
            </ul>
            <p>%2$s</p>',
            ($artist['artist_url']) ? sprintf('<li>Link: <a href="%1$s">%1$s</a></li>', $artist['artist_url']) : '',
            ($artist['artist_description']) ? $this->_lazytext($artist['artist_description']) : 'No further information stored.',
        );
        ?>
    </div>

    <p>
        <a href="javascript:history.back(-1);">&lArr; back</a>
    </p>
<?php endif ?>






<?php if (!$artist): ?>
    <div <?php print(($track) ? 'class="more"' : ''); ?>>
        <h2><?php print((!$track) ? 'Tracks Catalog' : 'More Tracks ...'); ?></h2>
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
