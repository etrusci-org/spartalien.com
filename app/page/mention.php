<?php
$mention_list = $this->get_mention_list();

$mention = [];
if (isset($this->Router->route['var']['id'])) {
    $mention = $this->get_mention((int) $this->Router->route['var']['id']);
}
?>



<section>
    <?php if (!$mention) : ?>

        <h2>Mentions</h2>

    <?php else: ?>

        <h2>Mention: <?php print($mention['mention_subject']); ?></h2>

        <pre><?php print_r($mention); ?></pre>

        </section>
        <section class="more">
        <h3>More Mentions ...</h3>

    <?php endif; ?>

    <?php
    // var_dump($mention_list);
    foreach ($mention_list as $v) {
        printf('<a href="./mention/id:%1$s"%3$s>%2s</a> ',
            $v['mention_id'],
            $v['mention_subject'],
            (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['mention_id']) ? ' class="active"' : '',
        );
    }
    ?>
</section>
