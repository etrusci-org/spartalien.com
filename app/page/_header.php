<!DOCTYPE html>
<html lang="en">
<head>
    <base href="<?php print($this->conf['site_url']); ?>">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="application-name" content="<?php print($var_metatag['application-name']); ?>">
    <meta name="author" content="<?php print($var_metatag['author']); ?>">
    <meta name="generator" content="<?php print($var_metatag['generator']); ?>">
    <meta name="title" content="<?php print($var_metatag['title']); ?>">
    <meta name="description" content="<?php print($var_metatag['description']); ?>">
    <meta name="keywords" content="<?php print($var_metatag['keywords']); ?>">

    <meta property="og:title" content="<?php print($var_ogtag['og:title']); ?>">
    <meta property="og:url" content="<?php print($var_ogtag['og:url']); ?>">
    <meta property="og:description" content="<?php print($var_ogtag['og:description']); ?>">
    <meta property="og:type" content="<?php print($var_ogtag['og:type']); ?>">
    <meta property="og:image" content="<?php print($var_ogtag['og:image']); ?>">

    <link rel="alternate" href="./news.atom" type="application/atom+xml" title="SPARTALIEN.COM - News Atom Feed">
    <link rel="icon" href="./favicon.ico?v=<?php print($this->version['favicon']); ?>" type="image/x-icon">
    <link rel="stylesheet" href="./res/style.min.css?v=<?php print($this->version['css']); ?>">

    <title><?php print($this->get_page_title()); ?></title>
</head>
<body>
    <noscript>
        <div class="noscript">
            Consider enabling JavaScript or features like audio and video players won't work.
            <a href="//enable-javascript.com" target="_blank">Find instructions there</a>
        </div>
    </noscript>


    <header>
        <nav>
            <h1><?php $this->_phsc($this->conf['site_title']); ?></h1>
            <?php print($this->get_site_nav_html()); ?>
        </nav>
    </header>


    <main>
