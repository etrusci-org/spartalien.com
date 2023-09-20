<?php
$mention_list = $this->get_mention_list();

$mention = [];
if (isset($this->Router->route['var']['id'])) {
    $mention = $this->get_mention((int) $this->Router->route['var']['id']);
}
?>




<?php if ($mention): ?>
    <h2><?php $this->_phsc($mention['mention_subject']); ?></h2>

    <?php
    if ($mention['mention_description']) {
        printf(
            '<div class="box">
                <p>%s</p>
            </div>',
            $this->_lazytext($mention['mention_description'])
        );
    }

    foreach ($mention['mention_media'] as $v) {
        printf(
            '<div class="box">
                <div class="lazycode">%s</div>
            </div>',
            $v,
        );
    }
    ?>
<?php endif; ?>




<div <?php print(($mention) ? 'class="more"' : ''); ?>>
    <h2><?php print((!$mention) ? 'Appearances, Reviews, Interviews, and More' : 'More Mentions ...'); ?></h2>
    <div class="box">
        <ul class="grid-x-3 compact-lines">
            <?php
            foreach ($mention_list as $v) {
                printf('<li><a href="./mention/id:%1$s"%3$s>%2$s</a></li>',
                    $v['mention_id'],
                    $this->_hsc($v['mention_subject']),
                    (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['mention_id']) ? ' class="active"' : '',
                );
            }
            ?>
        </ul>
    </div>
</div>
