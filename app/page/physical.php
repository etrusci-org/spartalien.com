<?php
$phy_list = $this->get_phy_list();

$phy = [];
if (isset($this->Router->route['var']['id'])) {
    $phy = $this->get_phy((int) $this->Router->route['var']['id']);
}

// var_dump($phy_list);
?>



<section>
    <?php if (!$phy) : ?>

        <h2>Physical Things</h2>

    <?php else: ?>

        <h2>Thing: <?php print($phy['phy_name']); ?></h2>

        <pre><?php print_r($phy); ?></pre>

        </section>
        <section class="more">
        <h3>More Music Releases ...</h3>

    <?php endif; ?>

    <?php
    foreach ($phy_list as $v) {
        printf('<a href="./physical/id:%1$s"%3$s> ./file/cover/physical/%1$s-tn.jpg</a> ',
            $v['phy_id'],
            $v['phy_name'],
            (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['phy_id']) ? ' class="active"' : '',
        );
    }
    ?>
</section>
