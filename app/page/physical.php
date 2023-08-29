<?php
$phy_list = $this->get_phy_list();

$phy = [];
if (isset($this->Router->route['var']['id'])) {
    $phy = $this->get_phy((int) $this->Router->route['var']['id']);
}

// var_dump($phy);
// var_dump($phy_list);
?>



<?php if ($phy): ?>
    <section>
        <h2>Physical: <?php print($phy['phy_name']); ?></h2>

        <pre><?php print_r($phy); ?></pre>
    </section>
<?php endif; ?>


<section <?php print(($phy) ? 'class="more"' : ''); ?>>
    <?php print((!$phy) ? '<h2>Physical Things</h2>' : '<h3>More Things ...</h3>'); ?>

    <?php
    foreach ($phy_list as $v) {
        printf('<a href="./physical/id:%1$s"%3$s>%2$s</a> ',
            $v['phy_id'],
            $v['phy_name'],
            (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['phy_id']) ? ' class="active"' : '',
        );
    }
    ?>
</section>
