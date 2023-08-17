<?php
$cache_file_user       = $this->conf['cache_dir'].'/mixcloud-lowtechman-user.json';
$cache_file_cloudcasts = $this->conf['cache_dir'].'/mixcloud-lowtechman-cloudcasts.json';

$user           = $this->_json_dec(file_get_contents($cache_file_user));
$cloudcast_list = $this->_json_dec(file_get_contents($cache_file_cloudcasts));
?>


<h2>Mixtapes</h2>


<section>
    <p>
        Find me on Mixcloud:
        <a href="<?php printf('https://www.mixcloud.com/lowtechman/uploads/?order=latest', $user['url']); ?>"><?php print(str_replace('https://www.', '', trim($user['url'], '/'))); ?></a>
    </p>
    <ul>
        <li><?php print($user['cloudcast_count']); ?> Uploads</li>
        <li><?php print($user['follower_count']); ?> Followers</li>
    </ul>
</section>


<section>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Tags</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cloudcast_list as $v) {
                if (str_starts_with($v['slug'], 'planet-420')) continue;
                printf('
                    <tr>
                        <td><a href="%1$s" target="_blank">%2$s</a></td>
                        <td>%3$s</td>
                        <td>%4$s</td>
                    </tr>',
                    $v['url'],
                    $v['name'],
                    implode(', ', array_map(function(array $v) { return strtolower($v['name']); }, $v['tags'])),
                    date('Y-m-d', strtotime($v['created_time'])),
                );
            }
            ?>
        </tbody>
    </table>
</section>
