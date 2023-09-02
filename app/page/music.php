<?php
$rls_list = $this->get_rls_list();

$rls = [];
if (isset($this->Router->route['var']['id'])) {
    $rls = $this->get_rls((int) $this->Router->route['var']['id']);
}

// var_dump($rls);
// var_dump($rls_list);
?>


<?php if ($rls): ?>

    <h2><?php print($rls['rls_name']); ?></h2>

    <div class="grid-x-2">
        <?php
        // coverart
        printf('
            <div class="box">
                <a href="%1$s">
                    <img src="%2$s" alt="coverart">
                </a>
            </div>',
            $rls['rls_preview_image']['big'],
            $rls['rls_preview_image']['med'],
        );
        ?>

        <?php
        // player
        printf('
            <div class="box">
                <div class="lazycode">{
                    "type": "bandcamp%1$s",
                    "slug": "%2$s",
                    "trackCount": %3$s
                }</div>
            </div>',
            ($rls['rls_track_count'] == 1) ? 'Track' : 'Album',
            $rls['rls_bandcamp_id'],
            $rls['rls_track_count'],
        );
        ?>
    </div>

    <div class="grid-x-2">
        <?php
        // meta + description
        printf('
            <div class="box">
                <h3>Meta</h3>
                <ul class="meta">
                    <li>Type: %1$s</li>
                    <li>Track count: %2$s</li>
                    <li>Total runtime: %3$s [%4$ss]</li>
                    <li>Released: %5$s</li>
                    %6$s
                </ul>
                %7$s
            </div>',
            $rls['rls_type_name'],
            $rls['rls_track_count'],
            $rls['rls_runtime_total_human'],
            $rls['rls_runtime_total'],
            $rls['rls_pub_date'],
            ($rls['rls_upd_date']) ? sprintf('<li>Updated: %1$s</li>', $rls['rls_upd_date']) : '',
            ($rls['rls_description']) ? sprintf('<p>%s</p>', $this->_lazytext($rls['rls_description'])) : '',
        );


        // credit
        $track_credit = [];
        foreach ($rls['rls_track_list'] as $t) {
            foreach ($t['track_credit'] as $c) {
                $track_credit[] = sprintf('<p><code>[track %1$s]</code> %2$s</p>', $t['track_order'], $this->_lazytext($c));
            }
        }
        if ($rls['rls_credit'] || $track_credit) {
            print(
                '<div class="box">
                    <h3>Credits / Notes</h3>'
            );
            if ($rls['rls_credit']) {
                print(implode('', array_map(fn(string $v): string => sprintf('<p>%1$s</p>', $this->_lazytext($v)), $rls['rls_credit'])));
            }
            if ($track_credit) {
                print(implode('', $track_credit));
            }
            print('</div>');
        }
        ?>
    </div>


    <div class="grid-x-2">
        <?php
        // dist
        printf('
            <div class="box">
                <h3>Distribution</h3>
                <ul>
                    %1$s
                </ul>
            </div>',
            implode('', array_map(fn(array $v): string => sprintf('<li><a href="%1$s">%2$s</a></li>', $v['url'], ucwords($v['platform'])), $rls['rls_dist'])),
        );

        // tracklist
        print(
            '<div class="box">
                <h3>Tracklist</h3>
                <ul>'
        );
        foreach ($rls['rls_track_list'] as $v) {
            printf(
                '<li><code>%1$s.</code> %2$s<a href="./catalog/track:%5$s">%3$s</a> <code>[%4$s]</code></li>',
                $v['track_order'],
                ($v['artist_id'] != 1) ? sprintf('<a href="./catalog/artist:%1$s">%2$s</a> - ', $v['artist_id'], $v['artist_name']) : '',
                $v['track_name'],
                $v['track_runtime_human'],
                $v['track_id'],
            );
        }
        print('</ul></div>');
        ?>
    </div>

    <?php
    // media
    if ($rls['rls_media']) {
        printf('
            <div class="box">
                <h3>Related Media</h3>
                %1$s
            </div>',
            implode('', array_map(fn(string $v): string => sprintf('<div class="lazycode">%1$s</div>', $v), $rls['rls_media'])),
        );
    }
    ?>

    <!-- <pre><?php print_r($rls); ?></pre> -->
<?php endif; ?>


<div <?php print(($rls) ? 'class="more"' : ''); ?>>

    <h2><?php print((!$rls) ? 'Music For You, Them, And Me' : 'More Music ...'); ?></h2>

    <div class="grid">

        <?php
        foreach ($rls_list as $v) {
            printf('
                <a href="./music/id:%1$s" title="%2$s"%4$s>
                    <img src="%3$s" loading="lazy" alt="preview image">
                </a>',
                $v['rls_id'],
                $v['rls_name'],
                $v['rls_preview_image']['tn'],
                (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['rls_id']) ? ' class="active"' : '',
            );
        }
        ?>

    </div>

</div>
