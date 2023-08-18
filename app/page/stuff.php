<?php
$stuff_list = $this->get_stuff_list();

$stuff = [];
if (isset($this->Router->route['var']['id'])) {
    $stuff = $this->get_stuff((int) $this->Router->route['var']['id']);
}
?>



<section>
    <?php if (!$stuff) : ?>

        <h2>stuffs</h2>

    <?php else: ?>

        <h2>stuff: <?php print($stuff['stuff_name']); ?></h2>

        <pre><?php print_r($stuff); ?></pre>

        </section>
        <section class="more">
        <h3>More stuffs ...</h3>

    <?php endif; ?>

    <?php
    foreach ($stuff_list as $v) {
        printf('<a href="./stuff/id:%1$s"%3$s>%2$s</a> ',
            $v['stuff_id'],
            $v['stuff_name'],
            (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['stuff_id']) ? ' class="active"' : '',
        );
    }
    ?>
</section>
