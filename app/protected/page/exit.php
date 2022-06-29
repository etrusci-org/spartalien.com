<?php
$exitList = $this->getExit('list');




// exit list index
print('
    <div class="box">
        <h2>SELECTED EXIT ROUTES</h2>
    </div>'
);




// exit list
print('<div class="box">');
print('<div class="grid simple">');

print(implode('', array_map(function(array $v): string {
    return sprintf('<div class="row"><a href="%1$s" title="%1$s">%2$s</a></div>', $v['url'], $v['linkText']);
}, $exitList)));

print('</div>');
print('</div>');
