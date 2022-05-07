<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="<?php print($this->conf['baseURL']); ?>">

    <link rel="stylesheet" href="res/style.min.css">

    <title>SPARTALIEN.com</title>
</head>
<body>
    <nav>
        <a href="<?php print($this->routeURL('')); ?>">index</a>
        <a href="<?php print($this->routeURL('news')); ?>">news</a>
        <a href="<?php print($this->routeURL('audio')); ?>">audio</a>
        <a href="<?php print($this->routeURL('visual')); ?>">visual</a>
        <a href="<?php print($this->routeURL('merch')); ?>">merch</a>
        <a href="<?php print($this->routeURL('about')); ?>">about</a>
        <a href="<?php print($this->routeURL('cam')); ?>">cam</a>
        <a href="<?php print($this->routeURL('planet420')); ?>">planet420</a>
    </nav>

    <hr>
