@echo off

:: Usage:
::
:: $ cd <project_directory>/
:: $ ./tool/db-create.cmd

./tool/sqlite3.exe -init ./src/db/schema-main.sql ./app/protected/db/main.sqlite3
