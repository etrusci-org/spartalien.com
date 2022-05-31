@echo off

:: Requires:
:: - curl
::
:: Usage:
::
:: $ cd <project_directory>/
:: $ ./tool/dep-fetch.cmd

curl -o app/protected/lib/vendor/WebApp.php          https://raw.githubusercontent.com/etrusci-org/nifty/main/php/class/WebApp.php
curl -o app/protected/lib/vendor/WebRouter.php       https://raw.githubusercontent.com/etrusci-org/nifty/main/php/class/WebRouter.php
curl -o app/protected/lib/vendor/DatabaseSQLite3.php https://raw.githubusercontent.com/etrusci-org/nifty/main/php/class/DatabaseSQLite3.php
curl -o app/protected/lib/vendor/jdec.php            https://raw.githubusercontent.com/etrusci-org/nifty/main/php/function/jdec.php
curl -o app/protected/lib/vendor/hsc5.php            https://raw.githubusercontent.com/etrusci-org/nifty/main/php/function/hsc5.php
curl -o src/ts/vendor/scur.ts                        https://raw.githubusercontent.com/etrusci-org/scur/main/src/scur.ts
curl -o src/ts/vendor/scur.types.d.ts                https://raw.githubusercontent.com/etrusci-org/scur/main/src/scur.types.d.ts
