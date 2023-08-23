<?php
$rls_list = $this->get_rls_list();

$rls = [];
if (isset($this->Router->route['var']['id'])) {
    $rls = $this->get_rls((int) $this->Router->route['var']['id']);
}

// var_dump($rls);
// var_dump($rls_list);
?>



<section>
    <?php if (!$rls) : ?>

        <h2>Music Releases</h2>

    <?php else: ?>

        <h2>Release: <?php print($rls['rls_name']); ?></h2>

        <pre><?php print_r($rls); ?></pre>

        </section>
        <section class="more">
        <h3>More Music Releases ...</h3>

    <?php endif; ?>

    <div class="gallery grid">
        <?php
        foreach ($rls_list as $v) {
            printf('
                <a href="./music/id:%1$s" title="%2$s"%4$s>
                    <img src="%3$s" loading="lazy" alt="preview image">
                </a>',
                $v['rls_id'],
                $v['rls_name'],
                $v['rls_preview_image']['tn'],
                (isset($this->Router->route['var']['id']) && $this->Router->route['var']['id'] == $v['rls_id']) ? ' class="active"' : '',
            );
        }
        ?>
    </div>
</section>
