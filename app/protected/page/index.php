<div class="introSplash text-align-center">
    <div class="randomQuoteTyper">
        <div class="primeMirror">
            <?php
            function isPrime(int $num): bool {
                if ($num < 2) return false;
                if ($num == 2) return true;
                if ($num % 2 == 0) return false;
                $divLast = round($num ** 0.5) + 1;
                $divCurrent = 3;
                while ($divCurrent <= $divLast) {
                    if ($num % $divCurrent == 0) return false;
                    $divCurrent += 2;
                }
                return true;
            }
            $numRange = range(10, 100_000);
            $num = $numRange[array_rand($numRange)];
            $numx = strrev($num);
            printf('
                <span class="code">%3$s=</span>%1$s<span class="code">||</span>%2$s<span class="code">=%4$s</span>
                ',
                $num,
                $numx,
                (isPrime($num)) ? 'p' : 'n',
                (isPrime($numx)) ? 'p' : 'n',
            );
            ?>
        </div>
    </div>
</div>
