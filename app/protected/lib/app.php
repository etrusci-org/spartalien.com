<?php
declare(strict_types=1);


class App extends WebApp {
    public function parseLazyInput(string $input): string|array|null {
        $patterns = array(
            '/\n/', // linefeed
            '/\[b\](.*?)\[\/b\]/', // [b]bold[/b]
            '/\[i\](.*?)\[\/i\]/', // [i]italic[/i]
            '/\[url=(.*?)\](.*?)\[\/url\]/', // [url=link_url]link_text[/url]
            '/\[route=(.*?)\](.*?)\[\/route\]/', // [route=route_request]link_text[/route]
        );

        $replacements = array(
            '<br>',
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<a href="$1" rel="nofollow">$2</a>',
            sprintf('<a href="%1$s">%2$s</a>', $this->routeURL('$1'), '$2'),
        );

        return preg_replace($patterns, $replacements, $input);
    }


    public function getNews(string $mode): array {
        $data = array();

        switch ($mode) {
            case 'list':
                $q = '
                SELECT
                    id,
                    postedOn,
                    items
                FROM news
                ORDER BY postedOn DESC;';

                $data = $this->DB->query($q);

                foreach ($data as $k => $v) {
                    $data[$k]['items'] = jdec($v['items']);
                }
                break;

            case 'byDate':
                if (isset($this->route['var']['date'])) {
                    $q = '
                    SELECT
                        id,
                        postedOn,
                        items
                    FROM news
                    WHERE postedOn = :postedOn
                    ORDER BY postedOn DESC;';

                    $v = array(
                        array('postedOn', $this->route['var']['date'], SQLITE3_TEXT),
                    );

                    $data = $this->DB->querySingle($q, $v);

                    $data['items'] = jdec($data['items']);
                }
                break;
        }

        return $data;
    }


    public function getMusic(string $mode, array $kwargs=array()): array {
        $data = array();

        switch ($mode) {
            case 'list':
                $w = '';
                $v = array();

                // year
                if (isset($this->route['var']['year'])) {
                    $w = 'WHERE substr(audioRelease.releasedOn, 1, 4) = :year OR substr(audioRelease.updatedOn, 1, 4) = :year';
                    $v[] = array('year', $this->route['var']['year'], SQLITE3_TEXT);
                }

                // type
                if (isset($this->route['var']['type'])) {
                    $w = sprintf('WHERE lower(audioReleaseType.typeName) = :type');
                    $v[] = array('type', strtolower($this->route['var']['type']), SQLITE3_TEXT);
                }

                // free to download
                if (in_array('freedl', $this->route['flag'])) {
                    $w = 'WHERE audioRelease.freeToDownload = 1';
                }

                $q = sprintf('
                    SELECT
                        audioRelease.catalogID,
                        audioRelease.releaseName,
                        audioRelease.releasedOn,
                        audioRelease.updatedOn,
                        audioRelease.artistIDs,
                        audioReleaseType.typeName AS releaseType,
                    CASE
                        WHEN audioRelease.updatedOn IS NULL
                            THEN audioRelease.releasedOn
                            ELSE audioRelease.updatedOn
                    END releaseOrder
                    FROM audioRelease
                    LEFT JOIN audioReleaseType ON audioReleaseType.id = audioRelease.audioReleaseTypeID
                    %s
                    ORDER BY releaseOrder DESC, audioRelease.catalogID DESC;',
                    $w
                );

                $data = $this->DB->query($q, $v);

                foreach ($data as $k => $v) {
                    $data[$k]['artist'] = $this->getArtistByID(jdec($v['artistIDs']));
                }
                break;

            case 'byCatalogID':
                $catalogID = null;
                if (isset($kwargs['id'])) {
                    $catalogID = $kwargs['id'];
                }
                elseif (isset($this->route['var']['id'])) {
                    $catalogID = $this->route['var']['id'];
                }

                if ($catalogID) {
                    $q = '
                    SELECT
                        audioRelease.catalogID,
                        audioRelease.releaseName,
                        audioRelease.releasedOn,
                        audioRelease.updatedOn,
                        audioRelease.audioCatalogIDs,
                        audioRelease.artistIDs,
                        audioRelease.description,
                        audioRelease.credits,
                        audioRelease.thanks,
                        audioRelease.relatedMedia,
                        audioRelease.freeToDownload,
                        audioRelease.bandcampID,
                        audioRelease.bandcampHost,
                        audioRelease.bandcampSlug,
                        audioRelease.spotifyHost,
                        audioRelease.spotifySlug,
                        label.labelName,
                        label.labelURL,
                        audioReleaseType.typeName AS releaseType
                    FROM audioRelease
                    LEFT JOIN label ON label.id = audioRelease.labelID
                    LEFT JOIN audioReleaseType ON audioReleaseType.id = audioRelease.audioReleaseTypeID
                    WHERE audioRelease.catalogID = :catalogID;';

                    $v = array(
                        array('catalogID', $catalogID, SQLITE3_TEXT),
                    );

                    $data = $this->DB->querySingle($q, $v);

                    $data['artist'] = $this->getArtistByID(jdec($data['artistIDs']));
                    $data['audioCatalogIDs'] = jdec($data['audioCatalogIDs']);
                    $data['tracklist'] = $this->getAudioByID($data['audioCatalogIDs']);
                    $data['description'] = $this->parseLazyInput($data['description']);
                    $data['credits'] = jdec($data['credits']);
                    $data['thanks'] = jdec($data['thanks']);
                    $data['relatedMedia'] = jdec($data['relatedMedia']);
                }
                break;
        }

        return $data;
    }


    public function getMusicFilter(): array {
        $filter = array();

        // all
        $filter[] = array(
            'All',
            $this->routeURL('music'),
            !in_array('freedl', $this->route['flag']) && !isset($this->route['var']['year']) && !isset($this->route['var']['type']),
        );

        // years
        $q = '
        SELECT DISTINCT
            substr(releasedOn, 1, 4) AS year
        FROM audioRelease
        ORDER BY releasedOn DESC;';
        $dump = $this->DB->query($q);
        foreach ($dump as $v) {
            $filter[] = array(
                $v['year'],
                $this->routeURL(sprintf('music/year:%s', $v['year'])),
                isset($this->route['var']['year']) && $this->route['var']['year'] == $v['year'],
            );
        }

        // types
        $q = '
        SELECT DISTINCT
            audioReleaseType.typeName AS releaseType
        FROM audioRelease
        LEFT JOIN audioReleaseType ON audioReleaseType.id = audioRelease.audioReleaseTypeID
        ORDER BY audioReleaseType.typeName ASC;';
        $dump = $this->DB->query($q);
        foreach ($dump as $v) {
            $v['releaseType'] = str_replace('Digital ', '', $v['releaseType']);
            $filter[] = array(
                $v['releaseType'],
                $this->routeURL(sprintf('music/type:%s', strtolower($v['releaseType']))),
                isset($this->route['var']['type']) && strtolower($this->route['var']['type']) == strtolower($v['releaseType']),
            );
        }

        // free to download
        $filter[] = array(
            'FreeDL',
            $this->routeURL('music/freedl'),
            in_array('freedl', $this->route['flag']),
        );

        // dj mixes link
        $filter[] = array(
            'DJ-Mixes&nearr;',
            'https://mixcloud.com/lowtechman/uploads/?order=latest',
            NULL,
        );

        return $filter;
    }


    public function getArtistByID(int|array $id): array {
        $data = array();

        $q = '
        SELECT
            id,
            artistName,
            artistURL
        FROM artist
        WHERE id = :id;';

        if (is_int($id)) {
            $v = array(
                array('id', $id, SQLITE3_INTEGER),
            );
            $dump = $this->DB->querySingle($q, $v);
            if ($dump) {
                $data = $dump;
            }
        }

        if (is_array($id)) {
            foreach ($id as $i) {
                $v = array(
                    array('id', $i, SQLITE3_INTEGER),
                );
                $dump = $this->DB->querySingle($q, $v);
                if ($dump) {
                    $data[] = $dump;
                }
            }
        }

        return $data;
    }


    public function getAudioByID(string|array $catalogID): array {
        $data = array();

        $q = '
        SELECT
            id,
            catalogID,
            audioName,
            audioRuntime,
            bandcampID,
            bandcampHost,
            bandcampSlug,
            spotifyHost,
            spotifySlug
        FROM audio
        WHERE catalogID = :catalogID;';

        if (is_string($catalogID)) {
            $v = array(
                array('catalogID', $catalogID, SQLITE3_TEXT),
            );
            $dump = $this->DB->querySingle($q, $v);
            if ($dump) {
                $data = $dump;
            }
        }

        if (is_array($catalogID)) {
            foreach ($catalogID as $id) {
                $v = array(
                    array('catalogID', $id, SQLITE3_TEXT),
                );
                $dump = $this->DB->querySingle($q, $v);
                if ($dump) {
                    $data[] = $dump;
                }
            }
        }

        return $data;
    }
}
