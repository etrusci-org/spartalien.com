# INSTALL

adjust overwrites for `APP_MODE_PRODUCTION` at the end of `app/protected/conf.php`

---

run `app/protected/bin/1-gen-validrequests.php`

---

set `APP_MODE_PRODUCTION` to `true` in `app/protected/conf.php`

---

run `app/protected/bin/2-gen-cache.php`

---

set `APP_MODE_PRODUCTION` back to `false` in `app/protected/conf.php`

---

upload:
`app/protected/cache/       -> /home/protected/v8.app/cache/`
`app/protected/db/          -> /home/protected/v8.app/db/`
`app/protected/lib/         -> /home/protected/v8.app/lib/`
`app/protected/page/        -> /home/protected/v8.app/page/`
`app/protected/conf.php     -> /home/protected/v8.app/conf.php`
`app/protected/init.php     -> /home/protected/v8.app/init.php`
`app/protected/version.php  -> /home/protected/v8.app/version.php`

---

set permissions:
`cd /home/protected/v8.app/`
`chgrp -R web *`
`chmod 775 cache/ db/`
`chmod -R 664 cache/*`
`chmod 664 db/*`

---

adjust remote configuration:
`cd /home/protected/v8.app/`
`nano conf.php`
set `APP_MODE_PRODUCTION` to `true`

---

upload all files from `app/public/` to `/home/public/v8beta/`

---

set permissions:
`cd /home/public/v8beta/`
`chgrp web index.php`

---

adjust .htaccess:
`cd /home/public/v8beta/`
`nano .htaccess`
`comment out the RewriteRule for the local files redirect`

---

adjust index.php:
`cd /home/public/v8beta/`
`nano index.php`
change the require path to `/home/protected/v8.app/init.php`

---

upload files from `spartalien.com-files` repo to `/home/public/v8beta/file/.`

---
