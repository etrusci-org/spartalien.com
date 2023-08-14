<?php
$rls_list = $this->get_rls_list();

$rls = [];
if (isset($this->Router->route['var']['id'])) {
    $rls = $this->get_rls((int) $this->Router->route['var']['id']);
}
?>




<?php if (!$rls): ?>

    <h2>MUSIC RELEASES</h2>

<?php else: ?>


    <div class="grid-rls">

        <div class="rls-coverart">
            <?php
            printf('<a href="%2$s" class="imgprev"><img src="%1$s" class="fluid" alt="coverart"></a>',
                $rls['coverart_file']['med'],
                $rls['coverart_file']['big'],
            );
            ?>
        </div>

        <div class="rls-info">
            <?php
            printf('<h2>%1$s</h2>', $rls['name']);
            ?>

            <div class="meta">
                <?php
                printf('%1$s &middot; %2$s %3$s &middot; released %4$s%5$s',
                    $rls['type'],
                    $rls['track_count'],
                    ngettext('track', 'tracks', $rls['track_count']),
                    $rls['pub_date'],
                    ($rls['upd_date']) ? ' &middot; updated '.$rls['upd_date'] : '',
                );
                ?>
            </div>

            <div class="description">
                <?php
                if ($rls['description']) {
                    print(nl2br($rls['description'], false));
                }
                ?>
            </div>
        </div>

        <div class="rls-player">
            <?php
            printf('<span class="lazycode">{"type": "%1$s", "slug": "%2$s", "trackCount": %3$s}</span>',
                ($rls['track_count'] == 1) ? 'bandcampTrack' : 'bandcampAlbum',
                $rls['bandcamp_id'],
                $rls['track_count'],
            );
            ?>
        </div>

        <div class="rls-tracklist">
            <?php
            print('<ul>');
            $i = 1;
            foreach ($rls['track_list'] as $v) {
                printf('<li>%5$s. %1$s%2$s (%3$s) %4$s</li>',
                    (strtolower($v['artist']) != 'spartalien') ? $v['artist'].' - ' : '',
                    $v['name'],
                    $v['runtime_human'],
                    ($v['credit']) ? '<ul class="credits">'.implode('', array_map(function(string $c) { return '<li>'.$c.'</li>'; }, $v['credit'])).'</ul>' : '',
                    $i++,
                    // implode(', ', $v['dist_links']),
                );
            }
            print('</ul>');
            ?>
        </div>

        <div class="rls-credits">
            <?php
            if ($rls['credit']) {
                print('<ul>');
                array_map(function(string $v) {
                    printf('<li>%s</li>', $v);
                }, $rls['credit']);
                print('</ul>');
            }
            ?>
        </div>

        <div class="rls-media">
            <?php
            if ($rls['media']) {
                array_map(function(string $v) {
                    printf('<span class="lazycode">%s</span> ', $v);
                }, $rls['media']);
            }
            ?>
        </div>
    </div>



    <hr>
    <h3>MORE MUSIC RELEASES ...</h3>
<?php endif; ?>



<div class="grid">
    <?php
    foreach ($rls_list as $v) {
        printf('
            <div>
                <a href="./music/id:%1$s"><img src="%2$s" class="fluid" alt="coverart" loading="lazy"></a>
            </div>',
            $v['id'],
            $v['coverart_file']['tn'],
        );
    }
    ?>
</div>
