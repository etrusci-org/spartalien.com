# spartalien.com - Installation




## Prepare Local Files

Stop all running build tasks.

Run `rebuild.sh`.

Set `MAINTENANCE_MODE` in `app/public/index.php` to `true`.

---




## Upload Local Files To Remote Server

Upload the public and files directory.

`spartalien.com/app/public/ -> /home/public/`  
`spartalien.com-files/file/ -> /home/public/file/`

Everything else goes into the protected directory.

`spartalien.com/app/cache/    -> /home/protected/v9.app/cache/`  
`spartalien.com/app/db/       -> /home/protected/v9.app/db/`  
`spartalien.com/app/lib/      -> /home/protected/v9.app/lib/`  
`spartalien.com/app/log/      -> /home/protected/v9.app/log/`  
`spartalien.com/app/page/     -> /home/protected/v9.app/page/`  
`spartalien.com/app/conf.php/ -> /home/protected/v9.app/conf.php`

---




## Adjust Remote Files

`ssh spartalien`

Comment-in or delete the files redirect line `RewriteRule ^file(/.*)?$ /spartalien.com-files/file$1 [R=302,L]` in `/home/public/.htaccess`.

Change `LIB_INIT_FILE` to `/home/protected/v9.app/lib/init.php`.

In `/home/protected/v9.app/conf.php`:

- change `error_reporting_level` to `0`
- change `site_url_scheme` to `https`
- change `site_domain` to `spartalien.com`
- change `site_dir` to `/`
- change `caching_ttl` to `315_360_000`

`chgrp -R web /home/public/index.php`  
`chgrp -R web /home/protected/v9.app/cache/`  
`chgrp -R web /home/protected/v9.app/db/`  
`chgrp -R web /home/protected/v9.app/log/`

---




## Go Live

Set `MAINTENANCE_MODE` in `/home/public/index.php` back to `false`.

---




## Local Files Aftermath

Set `MAINTENANCE_MODE` in `app/public/index.php` back to `false`.
