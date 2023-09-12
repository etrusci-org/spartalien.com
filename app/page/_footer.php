    </main>


    <footer class="text-align-center">
        <p>
            <a class="scroll_to_top">&uArr; u p &uArr;</a>
        </p>

        <nav>
            <?php print($this->get_site_nav_html()); ?>
        </nav>

        <nav>
            (
            <a href="./purchase">Purchase</a>
            <a href="./privacy">Privacy</a>
            )
        </nav>

        <p><img src="./res/logo-small.png" alt="Logo" title="SPARTALIEN"></p>

        <p>&copy; <?php print(date('Y')); ?></p>
    </footer>

    <div class="imgzoom-target"></div>

    <script type="module" src="./res/main.js?v=<?php print($this->version['js']); ?>"></script>
</body>
</html>
