<?php
$stuff_list = $this->get_stuff_list();

$stuff = [];
if (isset($this->Router->route['var']['id'])) {
    $stuff = $this->get_stuff((int) $this->Router->route['var']['id']);
}
?>




<?php if ($stuff): ?>
    <h2><?php print($stuff['stuff_name']); ?></h2>

    <?php
    if ($stuff['stuff_description']) {
        printf(
            '<div class="box">
                <p>%s</p>
            </div>',
            $this->_lazytext($stuff['stuff_description']),
        );
    }


    foreach ($stuff['stuff_media'] as $v) {
        printf(
            '<div class="box">
                <div class="lazycode">%s</div>
            </div>',
            $v,
        );
    }
    ?>
<?php endif; ?>




<div <?php print(($stuff) ? 'class="more"' : ''); ?>>
    <h2><?php print((!$stuff) ? 'Miscellaneous Stuff' : 'More stuff ...'); ?></h2>
    <div class="box">
        <ul class="grid-x-3 compact-lines">
            <?php
            foreach ($stuff_list as $v) {
                printf('<li><a href="./stuff/id:%1$s"%3$s>%2$s</a></li>',
                    $v['stuff_id'],
                    $v['stuff_name'],
                    (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['stuff_id']) ? ' class="active"' : '',
                );
            }
            ?>
        </ul>
    </div>
</div>
