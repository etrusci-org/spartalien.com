<?php
declare(strict_types=1);
namespace s9com;


$var_metatag = [
    'application-name' => 'SPARTALIEN.COM',
    'author' => 'arT2 (etrusci.org)',
    'generator' => 'Brain',
    'title' => $this->get_page_title(),
    'description' => 'Original music, visuals, mixtapes, and some more.',
    'keywords' => 'SPARTALIEN, arT2, lowtechman, multimedia, digital, art, music, audio, video, visual, soundtrack, visual, code, experimental, original',
];


$var_ogtag = [
    'og:title' => $var_metatag['title'],
    'og:url' => $this->conf['site_url'].$this->Router->route['request'],
    'og:description' => $var_metatag['description'],
    'og:type' => 'website',
    'og:image' => $this->conf['site_url'].'res/og.jpg?v='.$this->version['og'],
];


$var_elsewhere = [
    'bandcamp' => ['Bandcamp', '//spartalien.bandcamp.com'],
    'mixcloud' => ['Mixcloud', '//mixcloud.com/lowtechman'],
    'twitch' => ['Twitch', '//twitch.tv/spartalien'],
    'odysee' => ['Odysee', '//odysee.com/@spartalien:2'],
    'youtube' => ['YouTube', '//youtube.com/@spartalien-com'],
    // 'spotify' => ['Spotify', '//open.spotify.com/artist/553FKlcVkf1YFU6dl129Ef'],
    'soundcloud' => ['SoundCloud', '//soundcloud.com/spartalien'],
    // 'amazon' => ['Amazon', '//music.amazon.com/search/spartalien'],
    // 'apple' => ['Apple', '//music.apple.com/artist/spartalien/1455263028'],
    // 'deezer' => ['Deezer', '//www.deezer.com/artist/50523232'],
    'resonate' => ['Resonate', '//stream.resonate.coop/artist/20951'],
    'discogs' => ['Discogs', '//discogs.com/artist/5977226'],
    'lastfm' => ['Last.fm', '//last.fm/user/spartalien'],
    'newsletter' => ['Insider-Club', '//eepurl.com/dqYlHr'],
    'discord' => ['Discord-Chat', '//spartalien.com/discord'],
    'instagram' => ['Instagram', '//instagram.com/spartalien'],
    'github' => ['GitHub', '//github.com/etrusci-org'],
    'etrusci' => ['etrusci.org', '//etrusci.org'],
];
