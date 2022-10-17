#!/usr/bin/env bash

input="./tmp/style.css"
output="./app/public/res/style.min.css"

csso \
    --watch \
    --stat \
    --comments none \
    --input-source-map auto \
    --source-map file \
    --input $input \
    --output $output