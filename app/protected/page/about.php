<div class="box">
    <h2>IN A NUTSHELL</h2>
    <p>Multimedia experimenter / Music addict / Human</p>
</div>


<div class="box">
    <h2>PREFERRED WAYS TO GET IN TOUCH</h2>
    <p>
        <a class="btn" data-scur="tFWasR3b6kmbm9GQzBXYyRXYslWZu5yYv12N0UDZzIDOlRmM3cDN2MWY4gDMzMGNiFWM1cTMkR2NzEDNxgzM2UjZ2cjZlRTMjdTYklzN2UTO4EjZjF2Y2EDO">Email<noscript> (JavaScript required)</noscript></a>
        <span class="btn nobr" data-scur="==ARpN3YvJHZ6AyUQFkUUFETJVkTjUzM3gzN0UDZzIDOlRmM3cDN2MWY4gDMzMGNiFWM1cTMkR2NzEDNxgzM2UjZ2cjZlRTMjdTYklzN2UTO4EjZjF2Y2EDO"><noscript>(JavaScript required)</noscript></span>
    </p>
</div>


<div class="box">
    <h2>ME ELSEWHERE</h2>
    <p>
        <?php
        foreach ($this->conf['elsewhere'] as $v) {
            if (strtolower($v[0]) == 'newsletter') continue;
            printf('
                <a class="btn" href="%2$s">%1$s</a>',
                $v[0],
                $v[1],
            );
        }
        ?>
    </p>
</div>
