<?php
$user = $this->get_mixcloud_data('user', 'lowtechman');
$cloudcasts = $this->get_mixcloud_data('cloudcasts', 'lowtechman');
?>


<h2>MIXTAPES</h2>


<h3><?php print($user['name']); ?></h3>
<p>
    <a href="<?php printf('https://mixcloud.com/lowtechman/uploads/?order=latest', $user['url']); ?>">
        <img src="<?php print($user['pictures']['medium']); ?>" alt="Mixcloud profile picture"><br>
        <?php print(str_replace('https://www.', '', trim($user['url'], '/'))); ?>
    </a>
</p>
<p>
    <?php print($user['cloudcast_count']); ?> Uploads<br>
    <?php print($user['follower_count']); ?> Followers
</p>

<hr>

<?php
foreach ($cloudcasts as $v) {
    printf('<a href="%2$s" title="%1$s"><img src="%3$s" alt="%1$s" loading="lazy"></a>',
        $v['name'],
        $v['url'],
        $v['pictures']['large'],
    );}
?>
