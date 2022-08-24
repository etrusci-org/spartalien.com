@echo off

:: etrusci-org/nifty/main
curl -o app/protected/lib/vendor/WebApp.php             https://raw.githubusercontent.com/etrusci-org/nifty/main/php/WebApp.php
curl -o app/protected/lib/vendor/WebRouter.php          https://raw.githubusercontent.com/etrusci-org/nifty/main/php/WebRouter.php
curl -o app/protected/lib/vendor/DatabaseSQLite3.php    https://raw.githubusercontent.com/etrusci-org/nifty/main/php/DatabaseSQLite3.php
curl -o app/protected/lib/vendor/MixcloudData.php       https://raw.githubusercontent.com/etrusci-org/nifty/main/php/MixcloudData.php
curl -o app/protected/lib/vendor/jsonDecode.php         https://raw.githubusercontent.com/etrusci-org/nifty/main/php/jsonDecode.php
curl -o app/protected/lib/vendor/jsonEncode.php         https://raw.githubusercontent.com/etrusci-org/nifty/main/php/jsonEncode.php
curl -o src/ts/vendor/LazyMedia.ts                      https://raw.githubusercontent.com/etrusci-org/nifty/main/typescript/LazyMedia.ts
curl -o src/ts/vendor/addTargetToExtLinks.ts            https://raw.githubusercontent.com/etrusci-org/nifty/main/typescript/addTargetToExtLinks.ts
curl -o src/ts/vendor/Scur.ts                           https://raw.githubusercontent.com/etrusci-org/nifty/main/typescript/Scur.ts

:: etrusci-org/nifty/dev
