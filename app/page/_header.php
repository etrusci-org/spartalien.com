<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="<?php print($this->conf['site_url']); ?>">

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
            <h1><?php print($this->conf['site_title']); ?></h1>
            <?php print($this->get_site_nav_html()); ?>
        </nav>
    </header>


    <main>
