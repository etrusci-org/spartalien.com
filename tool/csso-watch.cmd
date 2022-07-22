@echo off

csso ^
    --watch ^
    --stat ^
    --comments none ^
    --input-source-map auto ^
    --source-map file ^
    --input ./tmp/style.css ^
    --output ./app/public/res/style.min.css
