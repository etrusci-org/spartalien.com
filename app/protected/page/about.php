<div class="box">
    <h2>IN A NUTSHELL</h2>
    <p>Multimedia experimenter / Music addict / Human</p>
</div>


<div class="box">
    <h2>WAYS TO GET IN TOUCH</h2>
    <p>
        <a class="btn" data-scur="51|81|84|78|107|78|106|77|52|85|71|90|121|99|122|78|48|89|122|89|104|104|68|79|119|77|122|89|48|73|87|89|120|85|122|78|120|81|71|90|51|77|84|77|48|69|68|79|122|89|84|78|109|90|122|78|109|86|71|78|120|77|50|78|104|82|87|79|51|89|84|78|53|103|84|77|109|78|87|89|106|90|84|77|52|48|87|89|112|120|71|100|118|112|84|97|117|90|50|98|65|78|72|99|104|74|72|100|104|120|87|97|108|53|109|76|106|57|87|98">Email<noscript> (JavaScript required)</noscript></a>
        <span class="btn nobr" data-scur="61|61|119|78|48|85|68|90|122|73|68|79|108|82|109|77|51|99|68|78|50|77|87|89|52|103|68|77|122|77|71|78|105|70|87|77|49|99|84|77|107|82|50|78|122|69|68|78|120|103|122|77|50|85|106|90|50|99|106|90|108|82|84|77|106|100|84|89|107|108|122|78|50|85|84|79|52|69|106|90|106|70|50|89|50|69|68|79|69|108|50|99|106|57|109|99|107|112|68|73|84|66|86|81|83|82|86|81|77|108|85|82|79|78|83|78|122|99|68|79"><noscript>(JavaScript required)</noscript></span>
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
