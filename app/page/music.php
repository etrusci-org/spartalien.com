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


    <?php
    // coverart
    printf('<p><a href="%2$s" class="imgprev"><img src="%s" alt="coverart"></a></p>',
        $rls['coverart_file']['tn'],
        $rls['coverart_file']['big'],
    );


    // heading
    printf('<h2>%1$s</h2>',
        $rls['name'],
    );


    // meta
    printf('<h3>meta</h3><p>%1$s | %2$s %3$s | released: %4$s%5$s</p>',
        $rls['type'],
        $rls['track_count'],
        ngettext('track', 'tracks', $rls['track_count']),
        $rls['pub_date'],
        ($rls['upd_date']) ? ' | updated: '.$rls['upd_date'] : '',
    );


    // description
    if ($rls['description']) {
        printf('<h3>description</h3><p>%s</p>', $rls['description']);
    }


    // player
    print('<h3>player</h3>');
    printf('<span class="lazycode">{"type": "%1$s", "slug": "%2$s", "trackCount": %3$s}</span>',
        ($rls['track_count'] == 1) ? 'bandcampTrack' : 'bandcampAlbum',
        $rls['bandcamp_id'],
        $rls['track_count'],
    );


    // tracklist
    print('<h3>track_list</h3><ul>');
    $i = 1;
    foreach ($rls['track_list'] as $v) {
        printf('<li>%6$s. %1$s - %2$s (%3$s) [%4$s] %5$s</li>',
            $v['artist'],
            $v['name'],
            $v['runtime_human'],
            implode(', ', $v['dist_links']),
            ($v['credit']) ? '<ul>'.implode('', array_map(function(string $c) { return '<li>'.$c.'</li>'; }, $v['credit'])).'</ul>' : '',
            $i++,
        );
    }
    print('</ul>');
    // print('
    //     <h3>track_list</h3>
    //     <table>
    //         <thead>
    //             <tr>
    //                 <th>TRACK</th>
    //                 <th>ARTIST</th>
    //                 <th class="text-align-right">RUNTIME</th>
    //                 <th>CREDITS</th>
    //                 <th>PLATFORMS</th>
    //             </tr>
    //         </thead>
    //         <tbody>
    // ');
    // foreach ($rls['track_list'] as $v) {
    //     printf('
    //         <tr>
    //             <td>%1$s</td>
    //             <td>%2$s</td>
    //             <td class="text-align-right font-mono">%3$s</td>
    //             <td>%4$s</td>
    //             <td>%5$s</td>
    //         </tr>',
    //         $v['name'],
    //         $v['artist'],
    //         $v['runtime_human'],
    //         ($v['credit']) ? '<ul>'.implode('', array_map(function(string $c) { return '<li>'.$c.'</li>'; }, $v['credit'])).'</ul>' : '',
    //         implode(', ', $v['dist_links']),
    //     );
    // }
    // print('
    //         </tbody>
    //     </table>
    // ');

    // credits
    if ($rls['credit']) {
        print('<h3>rls_credit</h3><ul>');
        array_map(function(string $v) {
            printf('<li>%s</li>', $v);
        }, $rls['credit']);
        print('</ul>');
    }


    // media
    if ($rls['media']) {
        print('<h3>media</h3>');
        array_map(function(string $v) {
            printf('<span class="lazycode">%s</span>', $v);
        }, $rls['media']);

    }


    // dist
    if ($rls['dist_links']) {
        print('<h3>dist</h3><ul>');
        array_map(function(string $v) {
            printf('<li>%s</li>', $v);
        }, $rls['dist_links']);
        print('</ul>');
    }
    ?>


    <hr class="wide">
    <h3>MORE MUSIC RELEASES ...</h3>
<?php endif; ?>




<?php
foreach ($rls_list as $v) {
    // printf('<a href="./music/id:%1$s" title="%2$s"><img src="%3$s" alt="coverart" loading="lazy"></a>',
    printf('<a href="./music/id:%1$s" title="%2$s">%2$s</a> | ',
        $v['id'],
        $v['name'],
        $v['coverart_file']['tn'],
    );
}
?>
