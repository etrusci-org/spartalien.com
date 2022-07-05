@echo off

./tool/sqlite3.exe -init ./src/db/schema-main.sql ./app/protected/db/main.sqlite3
