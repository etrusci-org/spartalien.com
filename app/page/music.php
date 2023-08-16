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

        <pre><?php print_r($rls['rls_media']); ?></pre>
        <pre><?php print_r($rls); ?></pre>

        </section>
        <section class="more">
        <h3>More Music Releases ...</h3>

    <?php endif; ?>

    <?php
    foreach ($rls_list as $v) {
        printf('<a href="./music/id:%1$s">%2s</a> ',
            $v['rls_id'],
            $v['rls_coverart_file']['tn'],
        );
    }
    ?>

</section>
