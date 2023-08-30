    </main>


    <footer>
        <nav>
            <?php $this->print_site_nav(with_site_title: true); ?>
        </nav>

        <div class="grid content">
            <p>
                &copy; <?php print(date('Y')); ?>
            </p>

            <ul class="text-align-right">
                <li><a href="./purchases">Purchases</a></li>
                <li><a href="./privacy">Privacy</a></li>
                <li><a href="//github.com/etrusci-org/spartalien.com" target="_blank">Source</a></li>
                <li><a href="//github.com/etrusci-org/spartalien.com/pull/108" target="_blank">PR</a></li>
            </ul>
        </div>
    </footer>



    <script type="module">
        import { Scur } from './res/scur.js?v=<?php print($this->version['js']); ?>'
        // import { LazyMedia } from './res/lazymedia.js?v=<?php print($this->version['js']); ?>'
        // import { ImgPrev } from './res/imgprev.js?v=<?php print($this->version['js']); ?>'
        // import { BGColorFader } from './res/bgcolorfader.js?v=<?php print($this->version['js']); ?>'
        Scur.deobElements()
        // LazyMedia.embed()
        // ImgPrev.init()

        // document.querySelectorAll('a').forEach(e => {
        //     if (e.hostname && document.location.hostname != e.hostname) {
        //         e.setAttribute('target', '_blank')
        //     }
        // })

        // const bgfader = new BGColorFader([
        //     'hsl(0, 0%, 7%)',
        //     'hsl(0, 0%, 8%)',
        //     'hsl(0, 0%, 9%)',
        //     // 'hsl(0, 0%, 11%)',
        // ])
        // bgfader.start()
    </script>


</body>
</html>
