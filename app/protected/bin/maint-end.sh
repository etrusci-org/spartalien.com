#!/usr/bin/env bash

# Make sure the paths fit the remote server

cp -v /home/public/index.php /home/public/index-maint.php

mv -v /home/public/index-real.php /home/public/index.php
