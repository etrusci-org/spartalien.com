    </main>



    <footer class="text-align-center">

        <nav>
            <a href="javascript:window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });">&uArr; u p &uArr;</a>
            &middot; <?php print($this->get_site_nav_html(separator: '')); ?>
        </nav>

        <p>
            <img src="./res/logo-small.png" alt="Logo">
        </p>

        <p>
            &copy; <?php print(date('Y')); ?>
        </p>

    </footer>


    <script type="module">
        import { LazyMedia } from './res/lazymedia.js?v=<?php print($this->version['js']); ?>'

        window.addEventListener('load', () => {
            const LM = new LazyMedia()
            LM.autoembed()

            document.querySelectorAll('a').forEach(e => {
                if (e.hostname && document.location.hostname != e.hostname) {
                    console.debug(e.href)
                    e.setAttribute('target', '_blank')
                }
            })
        }, false)
    </script>
</body>
</html>
