    </main>


    <?php if ($this->route['node'] != 'index'): ?>
        <footer>
            <p>
                <?php
                foreach ($this->conf['elsewhere'] as $k => $v) {
                    printf('
                        <a href="%1$s"><img src="res/ico-%2$s.png" alt="%3$s" title="%3$s"></a>',
                        $v[1],
                        $k,
                        $v[0],
                    );
                }
                ?>
            </p>
            <p>&copy; 2016-<?php print(date('Y')); ?> SPARTALIEN.COM</p>
            <p>
                <a href="<?php print($this->routeURL('sitemap')); ?>"><img src="res/ico-sitemap.png" alt="Sitemap" title="Sitemap"></a>
                <a href="<?php print($this->routeURL('exit')); ?>"><img src="res/ico-exit.png" alt="Exit" title="Exit"></a>
            </p>
        </footer>
    <?php endif; ?>


    <div class="imagepreviewTarget" title="Click anywhere or press Escape to close"></div>


    <script src="res/main.js?v=<?php print(VERSION['js']); ?>" type="module"></script>
</body>
</html>
