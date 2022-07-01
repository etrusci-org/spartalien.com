<?php
// sitemap list index
printf('
    <div class="box">
        <h2>LOST?</h2>
        <p>The path you are looking for is probably hidden in this list of %1$s pages.</p>
    </div>',
    count(VALID_REQUESTS),
);




// sitemap list
print('<div class="box text-align-center">');
print('<a href="./">index</a>');

print(implode('<br>', array_map(function(string $v): string {
    if (!$v) return '';
    return sprintf('<a href="%1$s">%1$s</a>', $this->routeURL($v));
}, VALID_REQUESTS)));

print('</div>');
