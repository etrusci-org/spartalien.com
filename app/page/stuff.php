<?php
$stuff_list = $this->get_stuff_list();

$stuff = [];
if (isset($this->Router->route['var']['id'])) {
    $stuff = $this->get_stuff((int) $this->Router->route['var']['id']);
}
?>





<?php if ($stuff): ?>
    <h2><?php print($stuff['stuff_name']); ?></h2>


    <div class="grid-x-2">
        <?php
        foreach ($stuff['stuff_media'] as $v) {
            $lazycode = $this->_json_dec($v);

            printf(
                '<div class="box full-width">
                    %3$s
                    <div class="lazycode">{
                        "type": "%1$s",
                        "slug": "%2$s"
                    }</div>
                </div>',
                $lazycode['type'],
                $lazycode['slug'],
                ($lazycode['type'] == 'audio') ? sprintf('<h3>%s</h3>', basename($lazycode['slug'])) : '',
            );

        }
        // print(implode('', array_map(fn(string $v): string => sprintf('<div class="lazycode">%s</div>', $v), $stuff['stuff_media'])));
        ?>
    </div>
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

        <!-- <pre><?php print_r($stuff_list); ?></pre> -->
    </div>
</div>
