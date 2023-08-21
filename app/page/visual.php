<?php
$visual_list = $this->get_visual_list();

$visual = [];
if (isset($this->Router->route['var']['id'])) {
    $visual = $this->get_visual((int) $this->Router->route['var']['id']);
}

// var_dump($visual);
// var_dump($visual_list);
?>



<section>
    <?php if (!$visual) : ?>

        <h2>Visuals</h2>

    <?php else: ?>

        <h2>Visual: <?php print($visual['visual_name']); ?></h2>

        <pre><?php print_r($visual); ?></pre>

        </section>
        <section class="more">
        <h3>More visuals ...</h3>

    <?php endif; ?>

    <?php
    foreach ($visual_list as $v) {
        printf('<a href="./visual/id:%1$s"%3$s>%2$s</a> ',
            $v['visual_id'],
            $v['visual_name'],
            (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['visual_id']) ? ' class="active"' : '',
        );
    }
    ?>
</section>
