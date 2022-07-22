<div class="introSplash text-align-center">
    <div class="randomQuoteTyper">
        <div class="primeMirror">
            <?php
            $n = range(10, 100_000);
            $p = $n[array_rand($n)];
            $m = strrev($p);
            printf('%1$s<span class="code">|</span>%2$s', $p, $m);
            ?>
        </div>
    </div>
</div>
