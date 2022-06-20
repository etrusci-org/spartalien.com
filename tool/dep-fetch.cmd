@echo off

:: etrusci-org/nifty
curl -o app/protected/lib/vendor/DatabaseSQLite3.php    https://raw.githubusercontent.com/etrusci-org/nifty/main/php/DatabaseSQLite3.php
curl -o app/protected/lib/vendor/hsc5.php               https://raw.githubusercontent.com/etrusci-org/nifty/main/php/hsc5.php
curl -o app/protected/lib/vendor/jdec.php               https://raw.githubusercontent.com/etrusci-org/nifty/main/php/jdec.php
curl -o app/protected/lib/vendor/jenc.php               https://raw.githubusercontent.com/etrusci-org/nifty/main/php/jenc.php
curl -o app/protected/lib/vendor/WebApp.php             https://raw.githubusercontent.com/etrusci-org/nifty/main/php/WebApp.php
curl -o app/protected/lib/vendor/WebRouter.php          https://raw.githubusercontent.com/etrusci-org/nifty/main/php/WebRouter.php

::dev!
curl -o src/ts/vendor/LazyMedia.ts                      https://raw.githubusercontent.com/etrusci-org/nifty/dev/typescript/LazyMedia.ts

:: etrusci-org/scur
curl -o src/ts/vendor/scur.ts                           https://raw.githubusercontent.com/etrusci-org/scur/main/src/scur.ts
curl -o src/ts/vendor/scur.types.d.ts                   https://raw.githubusercontent.com/etrusci-org/scur/main/src/scur.types.d.ts
