<?php
error_reporting(0);
date_default_timezone_set('UTC');
const RELOAD_INTERVAL = 60;
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="<?php print(RELOAD_INTERVAL); ?>; url=<?php print($_SERVER['REQUEST_URI']); ?>">
    <title>Website Maintenance &middot;&middot;&middot; SPARTALIEN.com</title>
    <style>
        body { background: #000000; font-family: sans-serif; font-size: 1.25rem; text-align: center; line-height: 1.75; letter-spacing: .1rem; }
        body, a { color: #ffffff; }
        .nfo { color: #777777; }
    </style>
</head>
<body>
    <h1><a href="https://spartalien.com">SPARTALIEN.COM</a> - Website Maintenance</h1>
    <p>Updating the website. Everything should be back shortly. Thank you for your patience.</p>
    <p class="nfo">
        This page auto-reloads every minute and will redirect you back to where you came from when the maintenance is over.<br>
        Next auto-reload in ~<span class="next-reload-in"><?php print(RELOAD_INTERVAL); ?></span> seconds.
    </p>
    <p>
        <a href="https://spartalien.bandcamp.com" target="_blank">Bandcamp</a> &middot;
        <a href="https://open.spotify.com/artist/553FKlcVkf1YFU6dl129Ef" target="_blank">Spotify</a> &middot;
        <a href="https://instagram.com/spartalien" target="_blank">Instagram</a>
    </p>

    <script>
        const next_reload_in = document.querySelector('.next-reload-in')
        const time_start = Date.now()
        setInterval(() => {
            next_reload_in.textContent = Math.max(0, <?php print(RELOAD_INTERVAL); ?> + ((time_start - Date.now()) / 1_000)).toFixed(1)
        }, 100)
    </script>
</body>
</html>
