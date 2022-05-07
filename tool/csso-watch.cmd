@ECHO OFF

SET inputFile="./tmp/style.css"
SET outputFile="./app/public/res/style.min.css"

:: Usage:
::
:: $ cd <project-dir>/
:: $ ./csso-watch.cmd

csso ^
    --watch ^
    --stat ^
    --comments none ^
    --input-source-map auto ^
    --source-map none ^
    --input %inputFile% ^
    --output %outputFile%
