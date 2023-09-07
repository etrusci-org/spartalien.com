    </main>


    <footer class="text-align-center">
        <p>
            &uArr; <a href="javascript:window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });">u p</a> &uArr;
        </p>

        <nav>
            <?php print($this->get_site_nav_html()); ?>
        </nav>

        <p><img src="./res/logo-small.png" alt="Logo"></p>

        <p>&copy; <?php print(date('Y')); ?></p>

        <ul class="text-align-right">
            <li><a href="./purchases">Purchases</a></li>
            <li><a href="./privacy">Privacy</a></li>
        </ul>
    </footer>


    <script type="module" src="./res/main.js?v=<?php print($this->version['js']); ?>"></script>
</body>
</html>
