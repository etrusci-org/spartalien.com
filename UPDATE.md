# UPDATE

How to update the website on the production server.

---

## 1. Turn On Maintenance Mode On The Production Server

```sh
ssh spartalien
/home/protected/v8.app/bin/maint-start.sh
```

## 2. Upload Changed Files

Upload whatever has changed. Make sure permissions are kept or set correctly on new files.

## 3. Delete Cached Route Files

```sh
ssh spartalien
rm -v /home/protected/v8.app/cache/*.html
```

## 4. Turn Off Maintenance Mode On The Production Server

```sh
ssh spartalien
/home/protected/v8.app/bin/maint-end.sh
```
