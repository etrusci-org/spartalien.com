@echo off

sass ^
    --watch ^
    --update ^
    --style expanded ^
    --charset ^
    --source-map ^
    ./src/scss/style.scss:./tmp/style.css
