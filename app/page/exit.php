<?php
$exit_list = $this->DB->query('
    SELECT
        exit.id AS exit_id,
        exit.text AS exit_text,
        exit.description AS exit_description,
        exit.url AS exit_url
    FROM exit
    ORDER BY LOWER(exit.text) ASC;'
);
?>




<h2>Selected Exit Routes</h2>


<div class="box">
    <p>Links to cool software, services, websites, people, and more I'd like to recommend.</p>
</div>


<div class="box">
    <ul class="grid-x-3 compact-lines">
        <?php
        foreach ($exit_list as $v) {
            printf('
                <li>
                    <a href="%1$s" title="%4$s">%2$s</a>
                    %3$s
                </li>',
                $v['exit_url'],
                htmlspecialchars($v['exit_text']),
                ($v['exit_description']) ? sprintf('<br>%1$s', $this->_lazytext($v['exit_description'])) : '',
                ltrim($v['exit_url'], '/'),
            );
        }
        ?>
    </ul>
</div>


<div class="box">
    <p>Please keep in mind that I have no control over the content of the linked websites.</p>
    <p>If you want to report a site, or you find your site linked here and want to have it updated or removed, <a data-scur="61|61|103|78|105|86|84|77|53|77|87|77|107|49|121|89|104|86|84|77|116|81|84|82|48|73|84|76|53|77|50|89|108|49|105|90|109|82|71|78|104|74|68|79|105|66|84|90|106|66|106|75|48|85|85|79|68|100|122|77|119|77|84|76|69|74|87|90|48|48|67|78|105|90|106|78|116|69|69|79|109|82|87|76|67|70|84|78|122|85|68|82|51|89|85|81|121|81|85|82|107|89|122|89|50|77|106|89|107|100|106|78|116|85|68|78|105|104|84|76|48|73|71|78|104|49|83|89|122|107|84|78|116|85|69|82|122|69|68|77|70|70|84|78|69|90|69|79|121|48|87|89|112|120|71|100|118|112|84|97|117|90|50|98|65|78|72|99|104|74|72|100|104|120|87|97|108|53|109|76|106|57|87|98">let me know</a> <noscript>[Javascript required]</noscript>.</p>
</div>
