    </main>


    <footer class="text-align-center">
        <p>
            <a href="javascript:window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });">&uArr; u p &uArr;</a>
        </p>

        <nav>
            <?php print($this->get_site_nav_html()); ?>
        </nav>

        <nav>
            (
            <a href="./purchases">Purchases</a>
            <a href="./privacy">Privacy</a>
            )
        </nav>

        <p><img src="./res/logo-small.png" alt="Logo" title="SPARTALIEN"></p>

        <p>&copy; <?php print(date('Y')); ?></p>
    </footer>

    <script type="module" src="./res/main.js?v=<?php print($this->version['js']); ?>"></script>
</body>
</html>
