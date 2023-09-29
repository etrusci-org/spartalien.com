    </main>


    <footer class="text-align-center">
        <p><a class="scroll_to_top">&uArr; u p &uArr;</a></p>
        <nav><?php print($this->get_site_nav_html()); ?></nav>
        <p>{ <a href="./purchase">Purchase</a> &middot; <a href="./privacy">Privacy</a> }</p>
        <p><img src="./res/logo-small.png" alt="Logo" title="SPARTALIEN"></p>
        <p>&copy; <?php print(date('Y')); ?> SPARTALIEN</p>
    </footer>

    <div class="imgzoom-target"></div>

    <script type="module" src="./res/main.js?v=<?php print($this->version['js']); ?>"></script>
</body>
</html>
<!--
- <?php print($this->Router->get_route_id().' '.$this->_json_enc($this->Router->route).PHP_EOL); ?>
- <https://validator.w3.org/nu/?doc=<?php print(urlencode($this->conf['site_url'].$this->Router->route['request'])); ?>>
- <https://validator.w3.org/feed/check.cgi?url=<?php print(urlencode($this->conf['site_url'].'news.atom')); ?>>
- <https://github.com/etrusci-org/spartalien.com/>
- <https://www.codefactor.io/repository/github/etrusci-org/spartalien.com>
-->
