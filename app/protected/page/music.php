<?php
$q = '
SELECT audioRelease.catalogID, audioRelease.releaseName, audioRelease.releasedOn, audioRelease.updatedOn, audioRelease.artistIDs, audioRelease.audioCatalogIDs,
audioReleaseType.typeName AS releaseType,
CASE
    WHEN audioRelease.updatedOn IS NULL
        THEN audioRelease.releasedOn
        ELSE audioRelease.updatedOn
END releaseOrder
FROM audioRelease
LEFT JOIN audioReleaseType ON audioReleaseType.id = audioRelease.audioReleaseTypeID
ORDER BY releaseOrder DESC;';
$releaseList = $this->DB->query($q);
// print('<pre>'); print_r($releaseList);
?>



<h2>/music</h2>

<table>
    <thead>
        <tr>
            <th>title</th>
            <th>type</th>
            <th>date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($releaseList as $v) {
            printf('
                <tr>
                    <td><a href="%1$s">%2$s</a></td>
                    <td>%3$s</td>
                    <td>%4$s</td>
                </tr>
                ',
                $this->routeURL(sprintf('music/id:%s', $v['catalogID'])),
                $v['releaseName'],
                $v['releaseType'],
                $v['releasedOn'],
            );
        }

        ?>
    </tbody>
</table>
