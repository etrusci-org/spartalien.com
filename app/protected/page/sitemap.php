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
print('<ul>');
print('<li><a href="./">index</a></li>');

print(implode('', array_map(function(string $v): string {
    return sprintf('<li><a href="%1$s">%1$s</a></li>', $this->routeURL($v));
}, VALID_REQUESTS)));

print('</ul>');
print('</div>');
