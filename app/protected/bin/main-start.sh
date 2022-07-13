#!/usr/bin/env bash

# Make sure the paths fit the remote server

cp -v /home/public/index.php /home/public/index-real.php

mv -v /home/public/index-maint.php /home/public/index.php
