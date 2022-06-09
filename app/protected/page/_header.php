<!DOCTYPE html>
<html lang="<?php print($this->conf['locale']); ?>">
<head>
    <meta charset="<?php print($this->conf['encoding']); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="<?php print($this->conf['baseURL']); ?>">

    <link rel="stylesheet" href="res/style.min.css">

    <title><?php print($this->conf['siteTitle']); ?></title>
</head>
<body>
    <?php
    printf('
        <header>
            <h1>%1$s</h1>
            <nav>%2$s</nav>
        </header>
        ',
        ($this->route['node'] == 'index') ? '<img src="res/logo-small.png" alt="SPARTALIEN" title="SPARTALIEN">' : '<a href="./">SPARTALIEN</a>',
        $this->getNavHTML(),
    );
    ?>

    <main>
