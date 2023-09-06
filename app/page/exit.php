<?php
$exit_list = $this->DB->query('
    SELECT
        exit.text AS exit_text,
        exit.description AS exit_description,
        exit.url AS exit_url
    FROM exit
    ORDER BY RANDOM();'
);
?>




<h2>Selected Exit Routes</h2>


<div class="box">
    <ul class="grid-x-3 compact-lines">
        <?php
        foreach ($exit_list as $v) {
            printf('
                <li><a href="%1$s" title="%3$s%1$s">%2$s</a></li>',
                $v['exit_url'],
                $v['exit_text'],
                ($v['exit_description']) ? sprintf('%1$s : ', $v['exit_description']) : '',
            );
        }
        ?>
    </ul>
</div>


<div class="box">
    <p>The list order is automagically randomized from time to time. If you find your site linked here and want to have it updated or removed, let me know.</p>
</div>
