<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="<?php print($this->conf['site_url']); ?>">

    <link rel="stylesheet" href="./res/style.min.css?v=<?php print($this->version['css']); ?>">

    <title><?php print($this->get_page_title()); ?></title>
</head>
<body>
    <noscript>Javascript required</noscript>

    <header>
        <h1>
            <a href="."><?php print($this->conf['site_title']); ?></a>
        </h1>

        <nav>
            <?php $this->print_site_nav(); ?>
        </nav>

        <div class="font-mono">/<?php print($this->Router->route['request']); ?></div>
    </header>


    <main>
