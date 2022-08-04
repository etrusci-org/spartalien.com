<?php if ($this->route['node'] != 'news.atom'): ?>
    </main>


    <?php
    if ($this->route['node'] != 'index'):
    ?>
        <footer>
            <p>
                &copy; 2016-<?php print(date('Y')); ?> SPARTALIEN.COM
            </p>
            <p>
                <?php
                foreach ($this->conf['elsewhere'] as $k => $v) {
                    printf('
                        <a href="%1$s">%2$s</a> ',
                        $v[1],
                        $v[0],
                    );
                }
                ?>
            </p>
            <p>
                <a href="<?php print($this->routeURL('exit')); ?>">[&rarr;]</a>
            </p>
        </footer>
    <?php
    endif;
    ?>


    <div class="imagepreviewTarget"></div>

    <script>
        const routeRequest = '<?php print($this->route['request']); ?>'
    </script>


    <script src="res/main.js?v=<?php print(VERSION['js']); ?>" type="module"></script>
</body>
</html>
<!--
    / <?php print(($this->route['request']) ? $this->route['request'] : 'index'); ?>

    > output baked on: <?php print(date('Y-m-d H:i:s T')); ?>

    : made with 🧠 by arT2 (etrusci.org)
-->
<?php endif; ?>
