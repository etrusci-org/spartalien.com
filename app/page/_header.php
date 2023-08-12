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
    <noscript><div>Javascript required</div></noscript>

    <header>
        <nav>
            <a href="."<?php if ($this->Router->route['node'] == 'home') print(' class="active"'); ?>>home</a>
            <a href="./music"<?php if ($this->Router->route['node'] == 'music') print(' class="active"'); ?>>music</a>
            <a href="./catalog"<?php if ($this->Router->route['node'] == 'catalog') print(' class="active"'); ?>>catalog</a>
            <a href="./mixtapes"<?php if ($this->Router->route['node'] == 'mixtapes') print(' class="active"'); ?>>mixtapes</a>
            <a href="./visual"<?php if ($this->Router->route['node'] == 'visual') print(' class="active"'); ?>>visual</a>
            <a href="./stuff"<?php if ($this->Router->route['node'] == 'stuff') print(' class="active"'); ?>>stuff</a>
            <a href="./about"<?php if ($this->Router->route['node'] == 'about') print(' class="active"'); ?>>about</a>
            <a href="./search"<?php if ($this->Router->route['node'] == 'search') print(' class="active"'); ?>>search</a>
            <a href="./exit"<?php if ($this->Router->route['node'] == 'exit') print(' class="active"'); ?>>exit</a>
        </nav>

        <h1><a href="."><?php print($this->conf['site_title']); ?></a></h1>
    </header>


    <main>
