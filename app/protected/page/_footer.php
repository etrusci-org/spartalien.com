    </main>


    <?php
    if ($this->route['node'] != 'index'):
    ?>
        <footer>
            <p class="elsewhere">
                <?php
                foreach ($this->conf['elsewhere'] as $k => $v) {
                    printf('
                        <a href="%1$s">%2$s<span>%3$s</span>%4$s</a>',
                        $v[1],
                        substr($v[0], 0, 1),
                        substr($v[0], 1, -1),
                        substr($v[0], -1, 1),
                    );
                }
                ?>
            </p>
            <p>&copy; 2016-<?php print(date('Y')); ?> SPARTALIEN.COM</p>
            <p>
                <a href="<?php print($this->routeURL('sitemap')); ?>">Lost?</a>
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
<!-- <?php print(jenc($this->route)); ?> -->
