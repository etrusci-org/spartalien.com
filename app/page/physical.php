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
    <h2><?php print($phy['phy_name']); ?></h2>


    <?php
    if ($phy['phy_description']) {
        printf(
            '<div class="box">
                <p>%s</p>
            </div>',
            $this->_lazytext($phy['phy_description']),
        );
    }
    ?>

    <?php
    // media
    if ($phy['phy_media']) {
        printf('
            <div class="box">
                <h3>Media</h3>
                %1$s
            </div>',
            implode('', array_map(fn(string $v): string => sprintf('<div class="lazycode">%1$s</div>', $v), $phy['phy_media'])),
        );
    }
    ?>


    <!-- <pre><?php print_r($phy); ?></pre> -->
<?php endif; ?>





<div <?php print(($phy) ? 'class="more"' : ''); ?>>

    <h2><?php print((!$phy) ? 'Physical Things' : 'More Things ...'); ?></h2>

    <div class="grid">
        <?php
        foreach ($phy_list as $v) {
            printf(
                '<a href="./physical/id:%1$s" title="%2$s"%4$s>
                    <img src="%3$s" loading="lazy" alt="preview image">
                </a>',
                $v['phy_id'],
                $v['phy_name'],

                $v['phy_preview_image']['tn'],

                (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['phy_id']) ? ' class="active"' : '',
            );
        }
        ?>
    </div>

        <!-- <pre><?php print_r($phy_list); ?></pre> -->
    </div>
</div>










<!--
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
</section> -->
