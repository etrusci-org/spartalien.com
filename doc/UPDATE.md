# spartalien.com - Update




## Local

Stop all running build tasks.

Run `rebuild.sh`.

---




## Remote

`ssh spartalien`

Set `MAINTENANCE_MODE` in `/home/public/index.php` to `true`.

Delete `compiled_route_*` and `cached_route_*` files in `/home/protected/v9.app/cache/` directory.

Upload new/updated files.

Make sure completely new files get the right permissions.

Set `MAINTENANCE_MODE` in `/home/public/index.php` back to `false`.
