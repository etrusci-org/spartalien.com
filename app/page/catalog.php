<?php
$track_list = $this->get_track_list();
?>


<h2>TRACKS CATALOG</h2>


<table>
    <thead>
        <tr>
            <th>TRACK</th>
            <th>ARTIST</th>
            <th class="text-align-right">RUNTIME</th>
            <th>PLATFORMS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($track_list as $v) {
            printf('
                <tr>
                    <td>%1$s</td>
                    <td>%2$s</td>
                    <td class="font-mono text-align-right">%3$s</td>
                    <td>%4$s</td>
                </tr>',
                $v['name'],
                $v['artist_name'],
                $this->_seconds_to_dhms($v['runtime']),
                implode(', ', $this->bake_dist_links($v['dist'])),
            );
        }
        ?>
    </tbody>
</table>
