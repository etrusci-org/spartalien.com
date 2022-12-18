#!/usr/bin/env bash

input="./src/scss/style.scss"
output="./tmp/style.css"

sass \
    --watch \
    --update \
    --style expanded \
    --charset \
    --no-source-map \
    $input:$output
