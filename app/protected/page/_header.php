<?php if ($this->route['node'] != 'news.atom'): ?>
<!DOCTYPE html>
<html lang="<?php print($this->conf['locale']); ?>">
<head>
    <meta charset="<?php print($this->conf['encoding']); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="<?php print($this->conf['baseURL']); ?>">

    <meta name="application-name" content="<?php print($this->conf['metaApplicationName']); ?>">
    <meta name="author" content="<?php print($this->conf['metaAuthor']); ?>">
    <meta name="generator" content="<?php print($this->conf['metaGenerator']); ?>">
    <meta name="description" content="<?php print($this->conf['metaDescription']); ?>">
    <meta name="keywords" content="<?php print($this->conf['metaKeywords']); ?>">

    <meta property="og:title" content="<?php print($this->conf['ogTitle']); ?>">
    <meta property="og:url" content="<?php print($this->conf['baseURL']); ?>">
    <meta property="og:description" content="<?php print($this->conf['ogDescription']); ?>">
    <meta property="og:type" content="<?php print($this->conf['ogType']); ?>">
    <meta property="og:image" content="<?php print($this->conf['baseURL']); ?>res/og.jpg?v=<?php print(VERSION['og']); ?>">

    <link rel="alternate" href="news.atom" type="application/atom+xml" title="News Atom Feed">

    <link rel="icon" href="favicon.ico?v=<?php print(VERSION['favicon']); ?>" type="image/x-icon">

    <!--[if lt IE 11]>
        <link rel="preload" href="res/vendor/share-tech-v17-latin-regular.woff" as="font" type="font/woff" crossorigin>
    <![endif]-->
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
            <nav>
                %2$s &middot;
                <a href="%3$s"><img src="res/vendor/ico-search.svg" alt="SEARCH"></a>
                <a href="%4$s"><img src="res/vendor/ico-exit.svg" alt="EXIT"></a>
            </nav>
            ',
            ($this->route['node'] == 'index') ? '<img src="res/logo-small.png" alt="SPARTALIEN" title="SPARTALIEN">' : '<a href="./">SPARTALIEN</a>',
            $this->getNavHTML(),
            $this->routeURL('search'),
            $this->routeURL('exit'),
        );
        ?>
    </header>


    <main>
<?php endif; ?>
