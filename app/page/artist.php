<?php
$artist = [];
if (isset($this->Router->route['var']['id'])) {
    $artist = $this->get_artist((int) $this->Router->route['var']['id']);
}
?>


<section>
    <h2>Artist: <?php print($artist['artist_name']); ?></h2>

    <pre><?php print_r($artist); ?></pre>
</section>
