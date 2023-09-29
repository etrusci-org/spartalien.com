#!/usr/bin/env bash

initfile="./src/db/init.txt"
dbfile="./app/db/main.sqlite3"

if [ -f $dbfile ]; then
    echo "database file already exists: $dbfile"
    exit 1
fi

sqlite3 -init $initfile $dbfile
