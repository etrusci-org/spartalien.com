<?php
$cache_file_user = $this->conf['cache_dir'].'/mixcloud-lowtechman-user.json';
$cache_file_cloudcasts = $this->conf['cache_dir'].'/mixcloud-lowtechman-cloudcasts.json';

$user = $this->_json_dec(file_get_contents($cache_file_user));
$cloudcast_list = $this->_json_dec(file_get_contents($cache_file_cloudcasts));
?>




<h2>More Mixtapes</h2>


<div class="box">
    <p>
        These are some of my other mixtapes (beside <a href="./planet420">Planet 420</a>).
    </p>
    <p>
        Find me on Mixcloud: <a href="<?php print($var_elsewhere['mixcloud'][1]); ?>">lowtechman</a>
    </p>
</div>

<p>
    <input type="text" class="elfilter-input" placeholder="Filter mixtapes..." title="'uni' will find 'unicorns' and 'reunion'">
</p>

<div class="box">
    <table class="elfilter">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th>Mix</th>
                <th>Tags</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cloudcast_list as $v) {
                if (str_starts_with($v['slug'], 'planet-420')) continue;
                printf(
                    '<tr>
                        <td><a class="img imgzoom" href="%6$s"><img src="%5$s" class="tn" loading="lazy" alt="cover art"></a></td>
                        <td><a href="%1$s">%2$s</a></td>
                        <td>%3$s</td>
                    </tr>',
                    $v['url'],
                    $this->_hsc($v['name']),
                    implode(', ', array_map(function(array $v) { return $this->_hsc(strtolower($v['name'])); }, $v['tags'])),
                    date('Y-m-d', strtotime($v['created_time'])),
                    $v['pictures']['medium'],
                    $v['pictures']['1024wx1024h'],
                );
            }
            ?>
        </tbody>
    </table>
</div>
