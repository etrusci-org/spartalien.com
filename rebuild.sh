#!/usr/bin/env bash

sass --style expanded --charset --no-source-map "./src/scss":"./src/css"

csso --comments none --input-source-map none --source-map none --input "./src/css/style.css" --output "./app/public/res/style.min.css"

tsc -p "./tsconfig.json"

rm app/db/main.sqlite3

./purge_cache.sh

./create_database.sh

./bake_app_files.sh
