# INSTALL

How to install the website on the production server.

---

## Preparations

### Edit Configuration

Open `app/protected/conf.php` to make final edits and set `APP_MODE_PRODUCTION` to `true`. Make sure the production mode overwrites at the end of the file fit the remote server.

### Delete Cached Files

```sh
rm app/protected/cache/*.html
rm app/protected/cache/*.php
```

### Generate Valid Requests File

Run `php app/protected/bin/1-gen-validrequests.php`. This will generate and write valid routes to `app/protected/cache/validrequests.php`.

### Prime The Cache

Run `php app/protected/bin/2-gen-cache.php`. This will read `app/protected/cache/validrequests.php` and generate cache files from those routes in `app/protected/cache/`.

### Disable Files Redirect RewriteRule

Open `app/public/.htaccess` to comment-out the rewrite rule for the files redirect.

### Edit App Entry Path

Open `app/public/index.php` to change the require path to `/home/protected/v8.app/init.php`.

### Turn On Maintenance Mode On The Production Server

```sh
ssh spartalien
/home/protected/v8.app/bin/maint-start.sh
```

---

## Upload

### Upload Protected App Files

```text
app/protected/bin/main-start.sh ->  /home/protected/v8.app/bin/main-start.sh
app/protected/bin/main-end.sh   ->  /home/protected/v8.app/bin/main-end.sh
app/protected/cache/            ->  /home/protected/v8.app/cache/
app/protected/db/               ->  /home/protected/v8.app/db/
app/protected/lib/              ->  /home/protected/v8.app/lib/
app/protected/page/             ->  /home/protected/v8.app/page/
app/protected/conf.php          ->  /home/protected/v8.app/conf.php
app/protected/init.php          ->  /home/protected/v8.app/init.php
app/protected/version.php       ->  /home/protected/v8.app/version.php
```

### Set Permissions For Protected App Files

```sh
ssh spartalien
chgrp -R web /home/protected/v8.app/*
chmod 775 /home/protected/v8.app/cache/ /home/protected/v8.app/db/
chmod 664 /home/protected/v8.app/cache/*
chmod 664 /home/protected/v8.app/db/*
```

### Upload Public App Files

```text
app/public/res/         ->  /home/public/res/
app/public/.htaccess    ->  /home/public/.htaccess
app/public/favicon.ico  ->  /home/public/favicon.ico
app/public/index.php    ->  /home/public/index.php    (ommit this and upload it at the end of the install procedure if index-maint.php is already in use)
app/public/robots.txt   ->  /home/public/robots.txt
```

### Set Permissions for Public App Files

```sh
ssh spartalien
chgrp web /home/public/index.php
```

### Upload Files [Repo](https://github.com/etrusci-org/spartalien.com-files)

**Do not** include any repo files.

```text
spartalien.com-files/  ->  /home/public/file/
```

### Turn Off Maintenance Mode On The Production Server

```sh
ssh spartalien
/home/protected/v8.app/bin/maint-end.sh
```

---

## Undo Local Changes To Continue Development

### Disable Production Mode

Open `app/protected/conf.php` to set `APP_MODE_PRODUCTION` back to `false`.

### Enable Files Redirect RewriteRule

Open `app/public/.htaccess` to comment-out the rewrite rule for the files redirect.

### Edit App Entry Path Again

Open `app/public/index.php` to change the require path back to `../protected/init.php`.

### Optionally Delete Locally Cached Route Files

```sh
rm app/protected/cache/*.html
```

---

Yay, go test it at <https://spartalien.com>.
