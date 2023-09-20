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

        <p>&copy; <?php print(date('Y')); ?> SPARTALIEN.COM</p>
    </footer>

    <div class="imgzoom-target"></div>

    <script type="module" src="./res/main.js?v=<?php print($this->version['js']); ?>"></script>
</body>
</html>
<!--
>>> Website created by arT2 <etrusci.org> for SPARTALIEN <spartalien.com>
::: <?php print($this->Router->get_route_id().' '.$this->_json_enc($this->Router->route, flags: JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).PHP_EOL); ?>
!!! Dear aspiring hackers, please stop hammering - the data is there: <https://github.com/etrusci-org/spartalien.com/blob/main/src/db/data.sql>. Thank you.
-->
