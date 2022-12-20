#!/usr/bin/env bash

input="./src/scss/style.scss"
output="./src/css/style.css"

sass \
    --watch \
    --update \
    --style expanded \
    --charset \
    --no-source-map \
    $input:$output
