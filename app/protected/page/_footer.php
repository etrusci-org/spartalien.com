    </main>

    <footer>
        <?php
        foreach ($this->conf['elsewhere'] as $k => $v) {
            printf('
                <a href="%3$s"><img src="res/ico-%1$s.png" alt="%2$s" title="%2$s"></a>
                ',
                strtolower($k),
                $k,
                $v,
            );
        }
        ?>
    </footer>

    <script src="res/main.js?v=<?php print(filemtime('res/main.js')); ?>" type="module"></script>
</body>
</html>
<!--[ request: <?php print($this->route['request']); ?> ][ output baked on: <?php print(date('Y-m-d H:i:s T')); ?> ]-->
<!--+~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~+
    |                                        |
    |            ... part  of ...            |
    |                                        |
    |    [E(T]RU){SCI}      <etrusci.org>    |
    |                                        |
    |    9db4d94358800716731c342344427081    |
    |    bba3ff738df6b2ae1c523809c3941ec6    |
    |    5fcf1f2b2c77d01ce9e07d6e1a13c880    |
    |    f95364e1278f24877de3da51d140a1ea    |
    |                                        |
    +~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~+-->
