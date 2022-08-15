<?php
require __DIR__.'/../lib/CloudcastFetcher.php';

$CF = new CloudcastFetcher(user: 'lowtechman');
$CF->fetchAll();
?>

<div class="box">
    <h2>DJ Mixes</h2>
    <p>I like djing. It's fun.</p>
</div>


<div class="box">
    <div class="grid simple">
        <?php
        foreach ($CF->result as $v) {
            $tags = array_map(function(array $v) {
                return strtolower($v['name']);
            }, $v['tags']);
            $tags = implode(', ', $tags);

            print('<div class="row text-align-center">');

            printf('
                <a href="%2$s"><img src="%3$s" alt="%1$s" title="%2$s" loading="lazy"><br>
                %1$s</a><br>
                %4$s, %5$s
                ',
                $v['name'],
                $v['url'],
                $v['pictures']['large'],
                $this->secondsToString($v['audio_length']),
                $tags,
            );

            print('</div>');
        }
        ?>
    </div>
</div>
