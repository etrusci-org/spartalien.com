<?php if ($this->route['node'] != 'news.atom'): ?>
    </main>


    <?php
    if ($this->route['node'] != 'index'):
    ?>
        <footer>
            <p>
                &copy; 2016-<?php print(date('Y')); ?> SPARTALIEN.COM
            </p>
            <p><?php $this->printElsewhereButtons(); ?></p>
            <p>
                <a class="btn" href="<?php print($this->routeURL('privacy')); ?>">Privacy</a>
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
<?php endif; ?>
