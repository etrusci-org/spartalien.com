<?php
$artist = [];
if (isset($this->Router->route['var']['id'])) {
    $artist = $this->get_artist((int) $this->Router->route['var']['id']);
}
?>


<section>
    <p>
        &larr; <a href="javascript:history.back(-1);">back</a>
    </p>

    <h2>Artist: <?php print($artist['artist_name']); ?></h2>

    <pre><?php print_r($artist); ?></pre>
</section>
