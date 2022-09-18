<div class="box">
    <h2>IN A NUTSHELL</h2>
    <p>Multimedia experimenter / Music addict / Human</p>
</div>


<div class="box">
    <h2>WAYS TO GET IN TOUCH</h2>
    <p>
        <a class="btn" data-scur="51|81|84|78|107|78|106|77|52|85|71|90|121|99|122|78|48|89|122|89|104|104|68|79|119|77|122|89|48|73|87|89|120|85|122|78|120|81|71|90|51|77|84|77|48|69|68|79|122|89|84|78|109|90|122|78|109|86|71|78|120|77|50|78|104|82|87|79|51|89|84|78|53|103|84|77|109|78|87|89|106|90|84|77|52|48|87|89|112|120|71|100|118|112|84|97|117|90|50|98|65|78|72|99|104|74|72|100|104|120|87|97|108|53|109|76|106|57|87|98">Email<noscript> (JavaScript required)</noscript></a>
        <a class="btn" href="<?php print($this->conf['elsewhere']['discord'][1]); ?>"><?php print($this->conf['elsewhere']['discord'][0]); ?></a>
    </p>
</div>


<div class="box">
    <h2>ELSEWHERE</h2>
    <p>
        <?php
        foreach ($this->conf['elsewhere'] as $v) {
            if (strtolower($v[0]) == 'newsletter') continue;
            printf('
                <a class="btn" href="%2$s">%1$s</a>',
                $v[0],
                $v[1],
            );
        }
        ?>
    </p>
</div>
