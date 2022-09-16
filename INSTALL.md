# INSTALL

How to initially install the website on the production server.

- [Preparations](#preparations)
  - [1. Edit Configuration](#1-edit-configuration)
  - [2. Purge Cache](#2-purge-cache)
  - [3. Generate Valid Requests File](#3-generate-valid-requests-file)
  - [4. Prime Cache (Optional)](#4-prime-cache-optional)
  - [5. Disable Files Redirect RewriteRule](#5-disable-files-redirect-rewriterule)
  - [6. Edit App Entry Path](#6-edit-app-entry-path)
  - [7. Turn On Maintenance Mode On The Production Server](#7-turn-on-maintenance-mode-on-the-production-server)
- [Upload](#upload)
  - [1. Upload Protected App Files](#1-upload-protected-app-files)
  - [2. Set Permissions For Protected App Files](#2-set-permissions-for-protected-app-files)
  - [3. Upload Public App Files](#3-upload-public-app-files)
  - [4. Upload Static Files](#4-upload-static-files)
  - [5. Turn Off Maintenance Mode On The Production Server](#5-turn-off-maintenance-mode-on-the-production-server)
- [Undo Local Changes To Continue Development](#undo-local-changes-to-continue-development)
  - [1. Disable Production Mode](#1-disable-production-mode)
  - [2. Enable Files Redirect RewriteRule](#2-enable-files-redirect-rewriterule)
  - [3. Edit App Entry Path](#3-edit-app-entry-path)
  - [4. Purge Cache (Optional)](#4-purge-cache-optional)

---

## Preparations

### 1. Edit Configuration

Open `app/protected/conf.php` to make final edits and set `APP_MODE_PRODUCTION` to `true`. Make sure the production mode overwrites at the end of the file fit the remote server.

### 2. Purge Cache

```sh
rm app/protected/cache/*.*
```

### 3. Generate Valid Requests File

Run `php app/protected/bin/1-gen-validrequests.php`. This will generate and write valid routes to `app/protected/cache/validrequests.php`.
This command is saved in `.vscode/tasks.json` and could also be run with `CTRL+SHIFT+B`.

### 4. Prime Cache (Optional)

Run `php app/protected/bin/2-gen-cache.php`. This will read `app/protected/cache/validrequests.php` and generate cache files from those routes in `app/protected/cache/`.
This only makes sense if we are sure that all the pages will be requested before the next cache cleaning. Skip this and save some initial space.

### 5. Disable Files Redirect RewriteRule

Open `app/public/.htaccess` to comment-out the rewrite rule line for the files redirect.

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
app/public/index.php    ->  /home/public/index-real.php    (note the "-real" suffix!)
app/public/robots.txt   ->  /home/public/robots.txt
app/public/sitemap.xml  ->  /home/public/sitemap.xml
```

### 4. Upload Static Files

Repo: <https://github.com/etrusci-org/spartalien.com-files>
```text
spartalien.com-files/file/  ->  /home/public/file/
```

### 5. Turn Off Maintenance Mode On The Production Server

```sh
ssh spartalien
/home/protected/v8.app/bin/maint-end.sh
```

---

## Undo Local Changes To Continue Development

### 1. Disable Production Mode

Open `app/protected/conf.php` to set `APP_MODE_PRODUCTION` back to `false`.

### 2. Enable Files Redirect RewriteRule

Open `app/public/.htaccess` to uncomment the rewrite rule for the files redirect.

### 3. Edit App Entry Path

Open `app/public/index.php` to change the require path back to `../protected/init.php`.

### 4. Purge Cache (Optional)

```sh
rm app/protected/cache/*.*
```
You can keep `app/protected/cache/validrequests.php` unless you edited `$conf.validRequestPatterns` in `app/protected/conf.php` during the installation process.
