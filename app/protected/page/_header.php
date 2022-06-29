<!DOCTYPE html>
<html lang="<?php print($this->conf['locale']); ?>">
<head>
    <meta charset="<?php print($this->conf['encoding']); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="<?php print($this->conf['baseURL']); ?>">

    <!-- <meta name="application-name" content="spartalien.com"> -->
    <!-- <meta name="author" content="SPARTALIEN"> -->
    <!-- <meta name="generator" content="Brain"> -->
    <!-- <meta name="description" content="SPARTALIEN's Website"> -->
    <!-- <meta name="keywords" content="SPARTALIEN, multimedia, art, music, audio, soundtrack, visual, code, experimental, original"> -->

    <!-- <meta property="og:title" content="SPARTALIEN.com"> -->
    <!-- <meta property="og:url" content="https://spartalien.com"> -->
    <!-- <meta property="og:description" content="SPARTALIEN's Website"> -->
    <!-- <meta property="og:type" content="website"> -->
    <!-- <meta property="og:image" content="https://spartalien.com/ogp.png?v=<?php print(filemtime('ogp.png')); ?>"> -->

    <link rel="icon" href="favicon.ico?v=<?php print(filemtime('favicon.ico')); ?>" type="image/x-icon">

    <link rel="preload" href="res/share-tech-v17-latin-regular.woff2" as="font" type="font/woff2" crossorigin>

    <link rel="stylesheet" href="res/style.min.css?v=<?php print(filemtime('res/style.min.css')); ?>">

    <title><?php print($this->conf['siteTitle']); ?> :: <?php print($this->route['request']); ?></title>

</head>
<body>
    <noscript>
        <div class="noscript">Consider enabling JavaScript or features like audio and video players won't work. (<a href="//enable-javascript.com">instructions</a>)</div>
    </noscript>

    <header>
        <?php
        printf('
            <h1>%1$s</h1>
            <nav>%2$s</nav>
            ',
            ($this->route['node'] == 'index') ? '<img src="res/logo-small.png" alt="SPARTALIEN" title="SPARTALIEN">' : '<a href="./">SPARTALIEN</a>',
            $this->getNavHTML(),
        );
        ?>
    </header>


    <main>
