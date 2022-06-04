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
    if ($this->route['node'] == 'index') {

        printf('
            <header>
                <h1><img src="res/logo-small.png" alt="Logo"></h1>
                <nav>%1$s</nav>
            </header>
            ',
            $this->getNavHTML(),
        );


    }
    else {
        printf('
            <header>
                <h1><a href="%1$s">SPARTALIEN</a></h1>
                <nav>%2$s</nav>
            </header>
            ',
            $this->routeURL(),
            $this->getNavHTML(),
        );
    }

    ?>


    <main>
