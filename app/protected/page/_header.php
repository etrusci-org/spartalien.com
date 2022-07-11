<!DOCTYPE html>
<html lang="<?php print($this->conf['locale']); ?>">
<head>
    <meta charset="<?php print($this->conf['encoding']); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="<?php print($this->conf['baseURL']); ?>">

    <meta name="application-name" content="SPARTALIEN.COM">
    <meta name="author" content="SPARTALIEN">
    <meta name="generator" content="Brain">
    <meta name="description" content="SPARTALIEN's Website">
    <meta name="keywords" content="SPARTALIEN, multimedia, digital, art, music, audio, video, soundtrack, visual, code, experimental, original">

    <meta property="og:title" content="SPARTALIEN.COM">
    <meta property="og:url" content="<?php print($this->conf['baseURL']); ?>">
    <meta property="og:description" content="SPARTALIEN's Website">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?php print($this->conf['baseURL']); ?>res/og.jpg?v=<?php print(VERSION['og']); ?>">

    <link rel="icon" href="favicon.ico?v=<?php print(VERSION['favicon']); ?>" type="image/x-icon">

    <link rel="preload" href="res/vendor/share-tech-v17-latin-regular.woff2" as="font" type="font/woff2" crossorigin>

    <link rel="stylesheet" href="res/style.min.css?v=<?php print(VERSION['css']); ?>">

    <title><?php print($this->conf['siteTitle']); ($this->route['request']) ? print(' :: '.$this->route['request']) : ''; ?></title>
</head>
<body>
    <noscript><div class="noscript">Consider enabling JavaScript or features like audio and video players won't work. (<a href="//enable-javascript.com" target="_blank">instructions</a>)</div></noscript>


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
