@echo off

csso ^
    --watch ^
    --stat ^
    --comments none ^
    --input-source-map auto ^
    --source-map none ^
    --input ./tmp/style.css ^
    --output ./app/public/res/style.min.css
