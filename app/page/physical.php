<?php
$phy_list = $this->get_phy_list();

$phy = [];
if (isset($this->Router->route['var']['id'])) {
    $phy = $this->get_phy((int) $this->Router->route['var']['id']);
}
?>




<?php if ($phy): ?>
    <h2><?php $this->_phsc($phy['phy_name']); ?></h2>

    <?php
    if ($phy['phy_description']) {
        printf(
            '<div class="box">
                <p>%s</p>
            </div>',
            $this->_lazytext($phy['phy_description']),
        );
    }

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
<?php endif; ?>




<div <?php print(($phy) ? 'class="more"' : ''); ?>>
    <h2><?php print((!$phy) ? 'Physical Things' : 'More Things ...'); ?></h2>
    <div class="grid">
        <?php
        foreach ($phy_list as $v) {
            printf(
                '<a href="./physical/id:%1$s" title="%2$s"%4$s>
                    <img src="%3$s" class="tn" loading="lazy" alt="preview image">
                </a>',
                $v['phy_id'],
                $this->_hsc($v['phy_name']),
                $v['phy_preview_image']['tn'],
                (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['phy_id']) ? ' class="active"' : '',
            );
        }
        ?>
    </div>
</div>
