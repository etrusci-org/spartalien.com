<?php
$visual_list = $this->get_visual_list();

$visual = [];
if (isset($this->Router->route['var']['id'])) {
    $visual = $this->get_visual((int) $this->Router->route['var']['id']);
}
?>




<?php if ($visual): ?>
    <h2><?php print($visual['visual_name']); ?></h2>

    <?php
    foreach ($visual['visual_media'] as $v) {
        printf(
            '<div class="box">
                <div class="lazycode">%1$s</div>
            </div>',
            $v
        );
    }

    printf(
        '<div class="box">
            <h3>Meta</h3>
            <ul class="meta">
                <li>Created: %1$s</li>
                <li>Tool: %2$s</li>
            </ul>
            %3$s
        </div>',
        substr($visual['visual_pub_date'], 0, 4),
        $this->_lazytext($visual['visual_tool']),
        ($visual['visual_description']) ? sprintf('<p>%s</p>', $this->_lazytext($visual['visual_description'])) : '',
    );
    ?>
<?php endif; ?>




<div <?php print(($visual) ? 'class="more"' : ''); ?>>
    <h2><?php print((!$visual) ? 'Visuals For You, Them, And Me' : 'More Visuals ...'); ?></h2>
    <div class="grid">
        <?php
        foreach ($visual_list as $v) {
            printf('
                <a href="./visual/id:%1$s" title="%2$s"%4$s>
                    <img src="%3$s" class="tn" loading="lazy" alt="preview image">
                </a>',
                $v['visual_id'],
                sprintf('%1$s | %2$s', $this->_hsc($v['visual_name']), substr($v['visual_pub_date'], 0, 4)),
                $v['visual_preview_image']['tn'],
                (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['visual_id']) ? ' class="active"' : '',
            );
        }
        ?>
    </div>
</div>
