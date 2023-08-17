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
        <h1><a href="."><?php print($this->conf['site_title']); ?></a></h1>

        <nav>
            <ul>
                <li><a href="."<?php if ($this->Router->route['node'] == 'home') print(' class="active"'); ?>>home</a></li>
                <li><a href="./music"<?php if ($this->Router->route['node'] == 'music') print(' class="active"'); ?>>music</a></li>
                <li><a href="./catalog"<?php if ($this->Router->route['node'] == 'catalog') print(' class="active"'); ?>>catalog</a></li>
                <li><a href="./planet420"<?php if ($this->Router->route['node'] == 'planet420') print(' class="active"'); ?>>planet420</a></li>
                <li><a href="./mixtapes"<?php if ($this->Router->route['node'] == 'mixtapes') print(' class="active"'); ?>>mixtapes</a></li>
                <li><a href="./news"<?php if ($this->Router->route['node'] == 'news') print(' class="active"'); ?>>news</a></li>
                <li><a href="./mention"<?php if ($this->Router->route['node'] == 'mention') print(' class="active"'); ?>>mention</a></li>
                <li><a href="./about"<?php if ($this->Router->route['node'] == 'about') print(' class="active"'); ?>>about</a></li>
                <!-- <li><a href="./visual"<?php if ($this->Router->route['node'] == 'visual') print(' class="active"'); ?>>visual</a></li> -->
                <!-- <li><a href="./physical"<?php if ($this->Router->route['node'] == 'physical') print(' class="active"'); ?>>physical</a></li> -->
                <!-- <li><a href="./stuff"<?php if ($this->Router->route['node'] == 'stuff') print(' class="active"'); ?>>stuff</a></li> -->
                <!-- <li><a href="./search"<?php if ($this->Router->route['node'] == 'search') print(' class="active"'); ?>>search</a></li> -->
                <!-- <li><a href="./exit"<?php if ($this->Router->route['node'] == 'exit') print(' class="active"'); ?>>exit</a></li> -->
            </ul>
        </nav>

        <small class="font-mono">/<?php print($this->Router->route['request']); ?></small>
    </header>


    <main>
