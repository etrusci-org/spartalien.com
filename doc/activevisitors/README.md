# ActiveVisitors

Simple visitors activity log.

File: [app/lib/activevisitors.php](../../app/lib/activevisitors.php)

---




## Basic Usage

```php
// include class file
require 'activevisitors.php';

// create new instance, optionally overwrite defaults
$App = new \s9com\ActiveVisitors(
    // db_file: 'data/database.sqlite3',
    // timeout_after: 60 * 15,
    // hash_algo: 'ripemd160',
    testmode: true,
);

// log activity data
$App->log_activity();

// get activity data
$activity = $App->get_activity();

// do something with activity data
while ($row = $activity->fetchArray())
{
    printf('
        <p>client_hash: %1$s<br>last_seen: %2$d seconds ago<br>last_location: %3$s</p>',
        $row['client_hash'],
        time() - $row['last_seen'],
        $row['last_location'],
    );
}
```

Set `ActiveVisitors::$testmode` to `true` and you will be one of four random clients on each page reload. Only useful for testing.

Make sure the Webserver/PHP user on your system has read/write access to both the database directory and file. The directory must be writable because SQLite creates temporary journal files in the same directory as the current database file.

---




## License

See [LICENSE.md](./LICENSE.md)
