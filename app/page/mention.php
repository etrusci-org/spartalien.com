<?php
$mention_list = $this->get_mention_list();

$mention = [];
if (isset($this->Router->route['var']['id'])) {
    $mention = $this->get_mention((int) $this->Router->route['var']['id']);
}
?>





<?php if ($mention): ?>
    <h2><?php print($mention['mention_subject']); ?></h2>


    <?php
    if ($mention['mention_description']) {
        printf(
            '<div class="box">
                <p>%s</p>
            </div>',
            $this->_lazytext($mention['mention_description'])
        );
    }
    ?>


    <?php
    foreach ($mention['mention_media'] as $v) {
        printf(
            '<div class="box">
                <div class="lazycode">%s</div>
            </div>',
            $v,
        );
    }
    ?>

    <!-- <pre><?php print_r($mention); ?></pre> -->
<?php endif; ?>





<div <?php print(($mention) ? 'class="more"' : ''); ?>>

    <h2><?php print((!$mention) ? 'Mentions' : 'More Mentions ...'); ?></h2>

    <div class="box">
        <ul class="grid-x-3 compact-lines">
            <?php
            foreach ($mention_list as $v) {
                printf('<li><a href="./mention/id:%1$s"%3$s>%2$s</a></li>',
                    $v['mention_id'],
                    $v['mention_subject'],
                    (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['mention_id']) ? ' class="active"' : '',
                );
            }
            ?>
        </ul>

        <!-- <pre><?php print_r($mention_list); ?></pre> -->
    </div>
</div>
