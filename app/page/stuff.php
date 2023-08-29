<?php
$stuff_list = $this->get_stuff_list();

$stuff = [];
if (isset($this->Router->route['var']['id'])) {
    $stuff = $this->get_stuff((int) $this->Router->route['var']['id']);
}
?>


<?php if ($stuff): ?>
    <section>
        <h2>Stuff: <?php print($stuff['stuff_name']); ?></h2>

        <pre><?php print_r($stuff); ?></pre>
    </section>
<?php endif; ?>


<section <?php print(($stuff) ? 'class="more"' : ''); ?>>
    <?php print((!$stuff) ? '<h2>Miscellaneous Stuff</h2>' : '<h3>More Stuff ...</h3>'); ?>

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
