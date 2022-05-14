<?php
$releaseList = $this->getMusic('list');
$releaseByID = $this->getMusic('byCatalogID');

$filter = $this->getMusicFilter();
$filterHTML = array();
foreach ($filter as $v) {
    $filterHTML[] = sprintf('<a href="%2$s"%3$s>%1$s</a>', $v[0], $v[1], $v[2] ? ' class="active"' : '');
}
$filterHTML = implode(' &middot; ', $filterHTML);
?>



<?php
if (!$releaseByID) {
    print('<h2>music</h2>');
}
else {
    $rls = $releaseByID;

    $artist = array();
    $dump = $rls['artist'];
    if (count($dump) > 1) {
        foreach ($dump as $a) {
            if ($a['id'] != 1) {
                $artist[] = $a['artistName'];
            }
        }
    }

    $bandcampBtn = '';
    if ($rls['bandcampSlug']) {
        $bandcampBtn = sprintf(
            '<a href="%1$s" class="btn">%2$s</a>',
            $rls['bandcampHost'].$rls['bandcampSlug'],
            ($rls['freeToDownload']) ? 'FREE DOWNLOAD' : 'BUY',
        );
    }

    $spotifyBtn = '';
    if ($rls['spotifySlug']) {
        $spotifyBtn = sprintf(
            '<a href="%1$s" class="btn">STREAM</a>',
            $rls['spotifyHost'].$rls['spotifySlug']
        );
    }

    printf(
        '<h2>%s</h2>',
        $rls['releaseName']
    );

    printf('
        <p>
            [
            %1$s
            &middot;
            %2$s%3$s
            &middot;
            released on %4$s%5$s
            ]
        </p>',
        $rls['typeName'],
        ($rls['trackCount'] > 1) ? sprintf('%s tracks', $rls['trackCount']) : sprintf('%s track', $rls['trackCount']),
        ($artist) ? sprintf(' &middot; collab w/ %s', implode(' + ', $artist)) : '',
        $rls['releasedOn'],
        ($rls['updatedOn']) ? sprintf(' &middot; updated on %s', $rls['updatedOn']) : '',
    );

    printf(
        '<p>%s</p>',
        $this->parseLazyText($rls['description']),
    );

    printf(
        '<p>%1$s %2$s</p>',
        $bandcampBtn,
        $spotifyBtn,
    );


    printf(
        '<p><a href="file/cover/%1$s-big.png"><img src="file/cover/%1$s-med.jpg"></a></p>',
        $rls['catalogID'],
    );




    print('<hr><pre>');
    print_r($releaseByID);
    print('</pre>');

    print('<hr><h3>more music...</h3>');
}

printf(
    '<p>%s</p>',
    $filterHTML,
);
?>

<table>
    <thead>
        <tr>
            <th>title</th>
            <th>type</th>
            <th>tracks</th>
            <th>date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($releaseList as $v) {
            $artist = array();
            $dump = $v['artist'];
            if (count($dump) > 1) {
                foreach ($dump as $a) {
                    if ($a['id'] != 1) {
                        $artist[] = $a['artistName'];
                    }
                }
            }

            printf('
                <tr>
                    <td><a href="%1$s">%2$s</a>%3$s</td>
                    <td>%4$s</td>
                    <td>%5$s</td>
                    <td>%6$s</td>
                </tr>
                ',
                $this->routeURL(sprintf('music/id:%s', $v['catalogID'])),
                $v['releaseName'],
                ($artist) ? sprintf(' [Collab w/ %s]', implode(' + ', $artist)) : '',
                $v['releaseType'],
                $v['trackCount'],
                // $v['releasedOn'],
                ($v['updatedOn']) ? $v['updatedOn'] : $v['releasedOn'],
            );
        }
        ?>
    </tbody>
</table>
