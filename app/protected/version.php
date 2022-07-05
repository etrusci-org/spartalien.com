<?php
define('VERSION', array(
    'favicon' => filemtime('favicon.ico'),
    'og' => filemtime('res/og.jpg'),
    'css' => filemtime('res/style.min.css'),
    'js' =>
        array_sum(array_map(function(string $v): int {
            return filemtime($v);
        }, array_merge(
            glob('res/*.js'),
            glob('res/vendor/*.js'),
        ))),
));
