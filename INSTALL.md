# INSTALL

How to initially install the website on the production server.

---

## Preparations

### 1. Edit Configuration

Open `app/protected/conf.php` to make final edits and set `APP_MODE_PRODUCTION` to `true`. Make sure the production mode overwrites at the end of the file fit the remote server.

### 2. Delete Cached Files

```sh
rm app/protected/cache/*.html
rm app/protected/cache/*.php
```

### 3. Generate Valid Requests File

Run `php app/protected/bin/1-gen-validrequests.php`. This will generate and write valid routes to `app/protected/cache/validrequests.php`.

### 4. Prime The Cache (Optional)

Run `php app/protected/bin/2-gen-cache.php`. This will read `app/protected/cache/validrequests.php` and generate cache files from those routes in `app/protected/cache/`.

### 5. Disable Files Redirect RewriteRule

Open `app/public/.htaccess` to comment-out the rewrite rule for the files redirect.

### 6. Edit App Entry Path

Open `app/public/index.php` to change the require path to `/home/protected/v8.app/init.php`.

### 7. Turn On Maintenance Mode On The Production Server

```sh
ssh spartalien
/home/protected/v8.app/bin/maint-start.sh
```

---

## Upload

### 1. Upload Protected App Files

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

### 2. Set Permissions For Protected App Files

```sh
ssh spartalien
chgrp -R web /home/protected/v8.app/*
chmod 775 /home/protected/v8.app/cache/ /home/protected/v8.app/db/
chmod 664 /home/protected/v8.app/cache/*
chmod 664 /home/protected/v8.app/db/*
```

### 3. Upload Public App Files

```text
app/public/res/         ->  /home/public/res/
app/public/.htaccess    ->  /home/public/.htaccess
app/public/favicon.ico  ->  /home/public/favicon.ico
app/public/index.php    ->  /home/public/index.php    (ommit this and upload it at the end of the install procedure if index-maint.php is already in use)
app/public/robots.txt   ->  /home/public/robots.txt
```

### 4. Set Permissions for Public App Files

```sh
ssh spartalien
chgrp web /home/public/index.php
```

### 5. Upload Files [Repo](https://github.com/etrusci-org/spartalien.com-files)

```text
spartalien.com-files/file/  ->  /home/public/file/
```

### 6. Turn Off Maintenance Mode On The Production Server

```sh
ssh spartalien
/home/protected/v8.app/bin/maint-end.sh
```

---

## Undo Local Changes To Continue Development

### 1. Disable Production Mode

Open `app/protected/conf.php` to set `APP_MODE_PRODUCTION` back to `false`.

### 2. Enable Files Redirect RewriteRule

Open `app/public/.htaccess` to comment-out the rewrite rule for the files redirect.

### 3. Edit App Entry Path

Open `app/public/index.php` to change the require path back to `../protected/init.php`.

### 4. Delete Locally Cached Route Files (Optional)

```sh
rm app/protected/cache/*.html
```

---

- [README](README.md)
- [LICENSE](LICENSE.md)
- [INSTALL](INSTALL.md) ←
- [UPDATE](UPDATE.md)
- [BRAIN](BRAIN.md)
