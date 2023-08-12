#!/usr/bin/env bash

schemafile="./src/db/schema.sql"
dbfile="./app/db/main.sqlite3"

if [ -f $dbfile ]; then
    echo "database file already exists: $dbfile"
    exit 1
fi

sqlite3 -init $schemafile $dbfile
