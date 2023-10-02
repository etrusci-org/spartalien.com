    </main>


    <footer class="text-align-center">
        <p><a class="scroll_to_top">&uArr; u p &uArr;</a></p>
        <nav><?php print($this->get_site_nav_html()); ?></nav>
        <p>{ <a href="./purchase">Purchase</a> &middot; <a href="./privacy">Privacy</a> }</p>
        <p><img src="./res/logo-small.png" alt="Logo" title="SPARTALIEN"></p>
        <p>&copy; <?php print(date('Y')); ?> SPARTALIEN</p>
        <p class="activevisitors">
            ~ active visitors ~<br>
            <?php
            $activity = $this->ActiveVisitors->get_activity();
            while ($row = $activity->fetchArray())
            {
                printf('
                    <img src="https://www.gravatar.com/avatar/%1$s.jpg?s=50&default=retro" loading="lazy" alt="visitor" title="last seen: %2$s seconds ago on &lt;%3$s&gt;">',
                    $row['client_hash'],
                    time() - $row['last_seen'],
                    $row['last_location'],
                );
            }
            ?>
        </p>
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
