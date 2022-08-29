<?php
$MixcloudData = new MixcloudData();
$MixcloudData->cacheDir = $this->conf['cacheDir'];
$MixcloudData->errorFile = $this->conf['cacheDir'].'/mixcloud-error.log';
$MixcloudData->cacheTTL = 31_536_000_000;

$user = $MixcloudData->getUser('lowtechman');
$cloudcasts = $MixcloudData->getCloudcasts('lowtechman');
?>

<div class="box">
    <h2>DJ Mixes</h2>
    <p>I like djing. It's fun.</p>
</div>


<div class="box text-align-center">
    <h3><?php print($user['name']); ?></h3>
    <p>
        <a href="<?php printf('%suploads/?order=latest', $user['url']); ?>">
            <img src="<?php print($user['pictures']['medium']); ?>" alt="Mixcloud profile picture"><br>
            <?php print(str_replace('https://www.', '', trim($user['url'], '/'))); ?>
        </a>
    </p>
    <p>
        <?php print($user['cloudcast_count']); ?> Uploads<br>
        <?php print($user['follower_count']); ?> Followers
    </p>
</div>


<?php
if (!$cloudcasts) {
    print('
        <div class="box error">
            <p>Error while fetching Mixcloud data.</p>
            <p><a class="btn" data-scur="51|81|84|78|107|78|106|77|52|85|71|90|121|99|122|78|48|89|122|89|104|104|68|79|119|77|122|89|48|73|87|89|120|85|122|78|120|81|71|90|51|77|84|77|48|69|68|79|122|89|84|78|109|90|122|78|109|86|71|78|120|77|50|78|104|82|87|79|51|89|84|78|53|103|84|77|109|78|87|89|106|90|84|77|52|48|87|89|112|120|71|100|118|112|84|97|117|90|50|98|65|78|72|99|104|74|72|100|104|120|87|97|108|53|109|76|106|57|87|98">Please report this<noscript> (JavaScript required)</noscript></a></p>
        </div>
    ');
}
else {
    print('<div class="box">');
    print('<div class="grid simple">');

    foreach ($cloudcasts as $v) {
        $tags = array_map(function(array $v) {
            return strtolower($v['name']);
        }, $v['tags']);
        $tags = implode(', ', $tags);

        print('<div class="row text-align-center">');
        printf('
            <a href="%2$s"><img src="%3$s" alt="%1$s" title="%2$s" loading="lazy"><br>
            %1$s</a><br>
            %4$s, %5$s',
            $v['name'],
            $v['url'],
            $v['pictures']['large'],
            $tags,
            $this->secondsToString($v['audio_length']),
        );
        print('</div>');
    }

    print('</div>');
    print('</div>');
}
?>
