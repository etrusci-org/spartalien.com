@ECHO OFF

SET input="./src/scss/style.scss"
SET output="./tmp/style.css"

:: Usage:
::
:: $ cd <project-dir>/
:: $ ./sass-watch.cmd

sass ^
    --watch ^
    --update ^
    --style expanded ^
    --charset ^
    --source-map ^
    %input%:%output%
