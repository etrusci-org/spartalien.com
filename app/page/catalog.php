<?php
$track_list = $this->get_track_list();
// var_dump($track_list);
?>


<h2>TRACKS CATALOG</h2>


<table>
    <thead>
        <tr>
            <th>TRACK</th>
            <th>ARTIST</th>
            <th class="text-align-right">RUNTIME</th>
            <th>CREDITS</th>
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
                    <td class="text-align-right font-mono">%3$s</td>
                    <td>%4$s</td>
                    <td>%5$s</td>
                </tr>',
                $v['name'],
                $v['artist'],
                $v['runtime_human'],
                ($v['credit']) ? '<ul>'.implode('', array_map(function(string $c) { return '<li>'.$c.'</li>'; }, $v['credit'])).'</ul>' : '',
                implode(', ', $v['dist_links']),
            );
        }
        ?>
    </tbody>
</table>
