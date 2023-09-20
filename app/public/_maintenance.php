<?php
error_reporting(0);
date_default_timezone_set('UTC');
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60; url=<?php print($_SERVER['REQUEST_URI']); ?>">
    <title>Website Maintenance &middot;&middot;&middot; SPARTALIEN.com</title>
    <style>
        body { background: #000000; font-family: sans-serif; font-size: 1.5rem; text-align: center; line-height: 1.75; letter-spacing: .1rem; }
        body, a { color: #ffffff; }
        .nfo { color: #777777; }
    </style>
</head>
<body>
    <h1><a href="https://spartalien.com">SPARTALIEN.COM</a> - Website Maintenance</h1>
    <p>Updating the website. Everything will be back shortly. Thank you for your patience.</p>
    <p class="nfo">
        This page auto-reloads every minute and will redirect you back to where you came from when the maintenance is over.<br>
        Last reload on: <?php print(date('H:i T')); ?>
    </p>
    <p>
        <a href="https://spartalien.bandcamp.com" target="_blank">Bandcamp</a> &middot;
        <a href="https://open.spotify.com/artist/553FKlcVkf1YFU6dl129Ef" target="_blank">Spotify</a> &middot;
        <a href="https://instagram.com/spartalien" target="_blank">Instagram</a> &middot;
        <a href="https://twitter.com/spartalien" target="_blank">Twitter</a>
    </p>
</body>
</html>
