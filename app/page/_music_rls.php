<h2><?php print($rls['rls_name']); ?></h2>


<div class="rls">


    <div class="head grid content">
        <?php
        // coverart
        printf('
            <div class="coverart">
                <a href="./%1$s">
                    <img src="%2$s" alt="coverart">
                </a>
            </div>',
            $rls['rls_preview_image']['big'],
            $rls['rls_preview_image']['med'],
        );

        // player
        printf('
            <div class="player">
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


    <div class="info grid content">
        <?php
        // meta
        printf('
            <div class="meta">
                <h3>About This Release</h3>
                <p>
                    %1$s
                    &middot; %2$s %3$s
                    &middot; Released %4$s
                    %5$s
                </p>
                <p>
                    %6$s
                </p>
            </div>',
            $rls['rls_type_name'],
            $rls['rls_track_count'],
            ngettext('track', 'tracks', $rls['rls_track_count']),
            $rls['rls_pub_date'],
            ($rls['rls_upd_date']) ? sprintf('&middot; Updated %1$s', $rls['rls_upd_date']) : '',
            ($rls['rls_description']) ? $this->_lazytext($rls['rls_description']) : ''
        );

        // credit
        if ($rls['rls_credit']) {
            printf('
                <div class="credit">
                    <h3>Credits</h3>
                    %1$s
                </div>',
                $this->_json_enc($rls['rls_credit']),
            );
        }
        ?>
    </div>


    <?php
    // media
    if ($rls['rls_media']) {
        printf('
            <div class="media">
                <h3>Related Media</h3>
                %1$s
            </div>',
            $this->_json_enc($rls['rls_media']),
        );
    }
    ?>

</div>


























<!-- <hr> -->
<!-- <pre><?php print_r($rls); ?></pre> -->
