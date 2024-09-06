    </main>


    <footer class="text-align-center">
        <p><a class="scroll_to_top">&uArr; u p &uArr;</a></p>
        <nav><?php print($this->get_site_nav_html()); ?></nav>
        <p><img src="./res/logo-small.png" alt="Logo" title="SPARTALIEN"></p>
        <p>{ <a href="./privacy">Privacy</a> }</p>

        <div class="ourspace_webring_widget"></div>

        <p class="activevisitors">
            ~ visitors ~<br>
            {nocache}
            <?php
            $activity = $this->ActiveVisitors->get_activity();
            while ($row = $activity->fetchArray())
            {
                printf('
                    <img src="https://www.gravatar.com/avatar/%1$s.jpg?s=50&default=retro" loading="lazy" alt="visitor" title="last seen %2$s seconds ago on %3$s">',
                    $row['client_hash'],
                    time() - $row['last_seen'],
                    $row['last_location'],
                );
            }
            ?>
            {/nocache}
        </p>
        <p>&copy; <?php print(date('Y')); ?> SPARTALIEN</p>
    </footer>

    <div class="imgzoom-target"></div>

    <script type="module" src="./res/main.js?v=<?php print($this->version['js']); ?>"></script>
    <script src="https://ourspace.ch/widget.js/src:4"></script>
</body>
</html>
<!-- <?php print($this->Router->get_route_id().' /'.$this->Router->route['request']); ?> -->
