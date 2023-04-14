<?php
$physicalFolderID = 5747135;
$digitalFolderID = 5747141;
$cratesUpdatedOn = filemtime($this->conf['dbD6File']);

$DBD6 = new DatabaseSQLite3($this->conf['dbD6File']);
$DBD6->open();

$q = 'SELECT id, title, year, thumb FROM releases WHERE folder_id = :folder_id ORDER BY year DESC';
$v = [
    ['folder_id', $physicalFolderID, SQLITE3_INTEGER],
];
$releasesPhysical = $DBD6->query($q, $v);

$v = [
    ['folder_id', $digitalFolderID, SQLITE3_INTEGER],
];
$releasesDigital = $DBD6->query($q, $v);

$DBD6->close();
?>


<div class="box">
    <h2>MY PRECIOUS</h2>
    <p>Crates last updated on <?php print(date('Y-m-d', $cratesUpdatedOn)); ?>.</p>
</div>


<div class="box text-align-center">
    <p>(physical)</p>
    <?php
    foreach ($releasesPhysical as $release) {
        print('<a href="https://discogs.com/release/'.$release['id'].'" title="'.$release['title'].' ('.$release['year'].')"><img src="'.$release['thumb'].'" class="thumb" loading="lazy"></a> ');
    }
    ?>
</div>


<div class="box text-align-center">
    <p>(digital)</p>
    <?php
    foreach ($releasesDigital as $release) {
        print('<a href="https://discogs.com/release/'.$release['id'].'" title="'.$release['title'].' ('.$release['year'].')"><img src="'.$release['thumb'].'" class="thumb" loading="lazy"></a> ');
    }
    ?>
</div>
