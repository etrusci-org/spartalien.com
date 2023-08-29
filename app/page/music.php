<?php
$rls_list = $this->get_rls_list();

$rls = [];
if (isset($this->Router->route['var']['id'])) {
    $rls = $this->get_rls((int) $this->Router->route['var']['id']);
}

// var_dump($rls);
// var_dump($rls_list);
?>




<?php
if ($rls) {
    include $this->conf['page_dir'].'/_music_rls.php';
}
?>



<section <?php print(($rls) ? 'class="more"' : ''); ?>>

    <?php print((!$rls) ? '<h2>Music For You, Them, And Me</h2>' : '<h3>More Music ...</h3>'); ?>

    <div class="grid">
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
