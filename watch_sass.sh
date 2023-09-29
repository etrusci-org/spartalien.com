#!/usr/bin/env bash

input="./src/scss"
output="./src/css"

sass \
    --watch \
    --update \
    --style expanded \
    --charset \
    --no-source-map \
    $input:$output
