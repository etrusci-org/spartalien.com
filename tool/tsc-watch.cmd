@ECHO OFF

:: --------------------------------------
:: Usage:
:: $ cd <project_directory>/
:: $ ./tool/tsc-watch.cmd
::
:: Config:
SET tsconfigFile="./tsconfig.json"
:: --------------------------------------

tsc --watch -p %tsconfigFile%
