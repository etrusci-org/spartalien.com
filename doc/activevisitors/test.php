<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
    <style>
        /* cosmetics and test stuff */
        body { background-color: #000; padding: 1rem; }
        body, a { color: #ccc; }
    </style>
</head>
<body>
    <p>reload the page a few times and see what happens</p>


    <?php
    require '../../app/lib/activevisitors.php';

    $App = new \s9com\ActiveVisitors(
        db_file: '../../app/db/activevisitors.sqlite3',
        timeout_after: 10,
        // hash_algo: 'ripemd160',
        testmode: true,
    );

    $App->log_activity();

    $activity = $App->get_activity();

    while ($row = $activity->fetchArray())
    {
        printf('
            <p>client_hash: %1$s<br>last_seen: %2$d seconds ago<br>last_location: %3$s</p>',
            $row['client_hash'],
            time() - $row['last_seen'],
            $row['last_location'],
        );
    }
    ?>


</body>
</html>
