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
            <small class="font-mono">/<?php print($this->Router->route['request']); ?></small>
        </h1>

        <nav>
            <ul>
                <?php
                foreach ($this->conf['site_nav'] as $v) {
                    printf('<li><a href="%1$s"%3$s>%2$s</a></li>',
                        $v['link'],
                        $v['link_text'],
                        ($this->Router->route['node'] == $v['base_node']) ? ' class="active"' : '',
                    );
                }
                ?>
            </ul>
        </nav>


    </header>


    <main>
