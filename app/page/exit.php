<?php
$exit_list = $this->DB->query('
    SELECT
        exit.text AS exit_text,
        exit.description AS exit_description,
        exit.url AS exit_url
    FROM exit
    ORDER BY RANDOM();
');
// ORDER BY LOWER(exit.text) ASC
?>


<h2>Selected Exit Routes</h2>


<section>
    <div class="grid content">
        <?php
        foreach ($exit_list as $v) {
            printf('
                <div>
                    <a href="%1$s" target="_blank" title="%3$s%1$s">%2$s</a>
                </div>
                ',
                $v['exit_url'],
                $v['exit_text'],
                ($v['exit_description']) ? sprintf('%1$s : ', $v['exit_description']) : '',
            );
        }
        ?>
    </div>
</section>


<section>
    The list is randomized from time to time. If you find your site linked here and want to have it updated or removed, let me know.
</section>
<!-- <pre><?php print_r($exit_list); ?></pre> -->
