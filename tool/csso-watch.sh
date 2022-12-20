#!/usr/bin/env bash

input="./src/css/style.css"
output="./app/public/res/style.min.css"

csso \
    --watch \
    --stat \
    --comments none \
    --input-source-map none \
    --source-map none \
    --input $input \
    --output $output
