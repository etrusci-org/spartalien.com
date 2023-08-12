    </main>


    <footer>
        &copy; <?php print(date('Y')); ?>
    </footer>


    <div class="imgprev-target"></div>


    <script type="module">
        // import { Scur } from './res/scur.js?v=<?php print($this->version['js']); ?>';
        // import { LazyMedia } from './res/lazymedia.js?v=<?php print($this->version['js']); ?>';
        // import { ImgPrev } from './res/imgprev.js?v=<?php print($this->version['js']); ?>';
        // Scur.deobElements()
        // LazyMedia.embed()
        // ImgPrev.init()

        const anchors = document.querySelectorAll('a')
        anchors.forEach(e => {
            if (e.hostname && document.location.hostname != e.hostname) {
                e.setAttribute('target', '_blank')
            }
        })
    </script>

    </body>
</html>
