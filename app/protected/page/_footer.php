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
                <a href="<?php print($this->routeURL('privacy')); ?>">Privacy</a>
            </p>
        </footer>
    <?php
    endif;
    ?>


    <div class="imagepreviewTarget"></div>

    <script type="module">
        import { App } from './res/app.js?v=<?php print(VERSION['js']); ?>'
        window.addEventListener('load', () => {
            App.main('<?php print($this->route['request']); ?>')
        }, false)
    </script>
</body>
</html>
<!--
    / <?php print(($this->route['request']) ? $this->route['request'] : 'index'); ?>

    > output baked on: <?php print(date('Y-m-d H:i:s e')); ?>

    : made with 🧠 by arT2 (etrusci.org)
-->
<?php endif; ?>
