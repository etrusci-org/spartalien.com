

<div class="rls">

    <section class="head">
        <?php
        printf('
            <div class="coverart">
                <a href="%1$s" target="_blank">
                    <img src="%2$s" alt="coverart">
                </a>
            </div>',
            $rls['rls_preview_image']['big'],
            $rls['rls_preview_image']['med'],
        );

        printf('
            <h2>%1$s</h2>',
            $rls['rls_name'],
        );

        printf('
            <div class="meta">
                %1$s
                &middot; %2$s %3$s
                &middot; Released %4$s
                %5$s
            </div>',
            $rls['rls_type_name'],
            $rls['rls_track_count'],
            ngettext('track', 'tracks', $rls['rls_track_count']),
            $rls['rls_pub_date'],
            ($rls['rls_upd_date']) ? sprintf('&middot; Updated %1$s', $rls['rls_upd_date']) : '',
        );
        ?>
    </section>


    <section class="player">
        <?php
        printf('
            <div class="lazycode">{
                "type": "bandcamp%1$s",
                "slug": "%2$s",
                "trackCount": %3$s
            }</div>',
            ($rls['rls_track_count'] == 1) ? 'Track' : 'Album',
            $rls['rls_bandcamp_id'],
            $rls['rls_track_count'],
        );
        ?>
    </section>


    <?php
    if ($rls['rls_description']) {
        printf('
            <section class="description">
                %1$s
            </section>',
            $this->_lazytext($rls['rls_description']),
        );
    }
    ?>


    <section class="tracklist">
        <table>
            <tbody>
                <?php
                foreach ($rls['rls_track_list'] as $v) {
                    printf('
                        <tr>
                            <td class="text-align-right font-mono">%2$s.</td>
                            <td><a href="./track/id:%1$s">%3$s</a></td>
                            <td class="text-align-right font-mono">%4$s</td>
                        </tr>',
                        $v['track_id'],
                        $v['track_order'],
                        $v['track_name'],
                        $v['track_runtime_human'],
                    );
                }
                ?>
            </tbody>
        </table>
    </section>


    <?php
    if ($rls['rls_credit']) {
        printf('
            <section class="credit">
                %1$s
            </section>',
            $this->_json_enc($rls['rls_credit']),
        );
    }
    ?>

    <?php
    if ($rls['rls_media']) {
        printf('
            <section class="media">
                %1$s
            </section>',
            $this->_json_enc($rls['rls_media']),
        );
    }
    ?>


</div>


























<!-- <hr>
<pre><?php print_r($rls); ?></pre> -->
