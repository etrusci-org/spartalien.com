    <hr>

    <nav>
        <?php
        $nav = $this->getNavHTML();
        print($nav);
        ?>
    </nav>

    <hr>

    <pre>Route <?php print_r($this->route); ?></pre>

    <script src="res/main.js" type="module"></script>

</body>
</html>
