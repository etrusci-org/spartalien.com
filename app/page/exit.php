<?php
$exit_list = $this->DB->query('
    SELECT
        exit.text AS exit_text,
        exit.description AS exit_description,
        exit.url AS exit_url
    FROM exit
    ORDER BY LOWER(exit.text) ASC;
');
?>


<h2>Selected Exit Routes</h2>


<pre><?php print_r($exit_list); ?></pre>
