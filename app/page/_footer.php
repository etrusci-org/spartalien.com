    </main>


    <footer class="text-align-center">
        <p><a class="scroll_to_top">&uArr; u p &uArr;</a></p>

        <nav><?php print($this->get_site_nav_html()); ?></nav>

        <div class="grid-x-2">
            <p>( <a href="./purchase">Purchase</a>, <a href="./privacy">Privacy</a> )</p>
            <p>( &copy; <?php print(date('Y')); ?> SPARTALIEN )</p>
        </div>

        <p><img src="./res/logo-small.png" alt="Logo" title="SPARTALIEN"></p>
    </footer>

    <div class="imgzoom-target"></div>

    <script type="module" src="./res/main.js?v=<?php print($this->version['js']); ?>"></script>
</body>
</html>
<!--
<?php print($this->Router->get_route_id().' '.$this->_json_enc($this->Router->route).PHP_EOL); ?>
<https://github.com/etrusci-org/spartalien.com/>
-->
