@echo off

:: Requires:
:: - curl
::
:: Usage:
::
:: $ cd <project_directory>/
:: $ ./tool/dep-fetch.cmd

curl -o app/protected/lib/vendor/WebRouter.php       https://raw.githubusercontent.com/etrusci-org/nifty/main/php/class/WebRouter.php
curl -o app/protected/lib/vendor/DatabaseSQLite3.php https://raw.githubusercontent.com/etrusci-org/nifty/main/php/class/DatabaseSQLite3.php
curl -o app/protected/lib/vendor/jdec.php            https://raw.githubusercontent.com/etrusci-org/nifty/main/php/function/jdec.php

curl -o app/protected/lib/vendor/WebApp.php          https://raw.githubusercontent.com/etrusci-org/nifty/dev/php/class/WebApp.php
