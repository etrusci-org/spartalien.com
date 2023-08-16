    </main>


    <footer>
        <p>&copy; <?php print(date('Y').' '.$this->conf['site_title']); ?></p>
    </footer>



    <script type="module">
        import { Scur } from './res/scur.js?v=<?php print($this->version['js']); ?>';
        // import { LazyMedia } from './res/lazymedia.js?v=<?php print($this->version['js']); ?>';
        // import { ImgPrev } from './res/imgprev.js?v=<?php print($this->version['js']); ?>';
        Scur.deobElements()
        // LazyMedia.embed()
        // ImgPrev.init()

        // document.querySelectorAll('a').forEach(e => {
        //     if (e.hostname && document.location.hostname != e.hostname) {
        //         e.setAttribute('target', '_blank')
        //     }
        // })
    </script>

</body>
</html>








    <!-- <div class="imgprev-target"></div> -->
