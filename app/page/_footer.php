    </main>


    <footer>
        <p>&copy; <?php print(date('Y') . ' ' . $this->conf['site_title']); ?></p>
    </footer>



    <script type="module">
        // import { Scur } from './res/scur.js?v=<?php print($this->version['js']); ?>'
        // import { LazyMedia } from './res/lazymedia.js?v=<?php print($this->version['js']); ?>'
        // import { ImgPrev } from './res/imgprev.js?v=<?php print($this->version['js']); ?>'
        import { BGColorFader } from './res/bgcolorfader.js?v=<?php print($this->version['js']); ?>'
        // Scur.deobElements()
        // LazyMedia.embed()
        // ImgPrev.init()

        // document.querySelectorAll('a').forEach(e => {
        //     if (e.hostname && document.location.hostname != e.hostname) {
        //         e.setAttribute('target', '_blank')
        //     }
        // })

        const bgfader = new BGColorFader([
            '121212',
            '0f0f0f',
            '0d0d0d',
            '0a0a0a',
            '0d0d0d',
            '0f0f0f',
        ])

        bgfader.start()

    </script>


</body>
</html>
