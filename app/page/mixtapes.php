<?php
$user = $this->get_mixcloud_data('user');
$cloudcasts = $this->get_mixcloud_data('cloudcasts');
?>


<h2>Mixtapes</h2>


<section>
    <p>
        Find me on Mixcloud:
        <a href="<?php printf('https://mixcloud.com/lowtechman/uploads/?order=latest', $user['url']); ?>"><?php print(str_replace('https://www.', '', trim($user['url'], '/'))); ?></a>
    </p>
    <ul>
        <li><?php print($user['cloudcast_count']); ?> Uploads</li>
        <li><?php print($user['follower_count']); ?> Followers</li>
    </ul>
</section>


<section>
    <?php
    foreach ($cloudcasts as $v) {
        // printf('<a href="%2$s" title="%1$s"><img src="%3$s" alt="%1$s" loading="lazy"></a>',
        printf('<a href="%2$s" title="%1$s" target="_blank">%1$s</a> ',
            $v['name'],
            $v['url'],
            $v['pictures']['large'],
        );}
    ?>
</section>
