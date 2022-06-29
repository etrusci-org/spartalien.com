<?php
declare(strict_types=1);


class App extends WebApp {
    public function validateRequest(): void {
        if (!VALID_REQUESTS) {
            return;
        }

        // prepare request
        $request = trim($this->route['request'], ' /');

        // prepare/expand valid requests
        $validRequests = array();

        foreach (VALID_REQUESTS as $requestPattern) {
            // range :[n-n]
            if (preg_match('/(.+:)\[(\d+)-(\d+)\]/i', $requestPattern, $patternMatch)) {
                foreach (range($patternMatch[2], $patternMatch[3]) as $v) {
                    $validRequests[] = sprintf('%1$s%2$s', $patternMatch[1], $v);
                }
            }
            // or :[a|b]
            else if (preg_match('/(.+:)\[([\w|]+)\]/i', $requestPattern, $patternMatch)) {
                foreach (explode('|', $patternMatch[2]) as $v) {
                    $validRequests[] = sprintf('%1$s%2$s', $patternMatch[1], $v);
                }
            }
            // default
            else {
                $validRequests[] = $requestPattern;
            }
        }

        // set node to 404 if invalid request
        if (!in_array($request, $validRequests)) {
            $this->route['node'] = '404';
        }
    }


    protected function getNavHTML(string $separator=' &middot; '): string {
        return implode($separator, array_map(function(array $v): string {
            return sprintf(
                '<a href="%1$s"%3$s>%2$s</a>',
                $this->routeURL($v[0]),
                $v[1],
                ($this->route['node'] == substr($v[0], 0, strlen($this->route['node']))) ? ' class="active"' : '',
            );
        }, $this->conf['nav']));
    }


    protected function getNews(string $mode): array {
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

            case 'byID':
                if (isset($this->route['var']['id'])) {
                    $q = '
                    SELECT
                        id,
                        postedOn,
                        items
                    FROM news
                    WHERE id = :id
                    ORDER BY postedOn DESC;';

                    $v = array(
                        array('id', $this->route['var']['id'], SQLITE3_TEXT),
                    );

                    $data = $this->DB->querySingle($q, $v);

                    if ($data) {
                        $data['items'] = jdec($data['items']);
                    }
                }
                break;
        }

        return $data;
    }


    protected function getAudio(string $mode, array $kwargs=array()): array {
        $data = array();

        switch ($mode) {
            case 'releaseList':
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
                        audioRelease.id,
                        audioRelease.releaseName,
                        audioRelease.releasedOn,
                        audioRelease.updatedOn,
                        audioRelease.audioIDs,
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
                    ORDER BY releaseOrder DESC, audioRelease.id DESC;',
                    $w
                );

                $data = $this->DB->query($q, $v);

                foreach ($data as $k => $v) {
                    $data[$k]['artist'] = $this->getArtistByID(jdec($v['artistIDs']));
                    $data[$k]['audioIDs'] = jdec($v['audioIDs']);
                    $data[$k]['trackCount'] = count($data[$k]['audioIDs']);
                }
                break;

            case 'releaseByID':
                $id = null;
                if (isset($kwargs['id'])) {
                    $id = intval($kwargs['id']);
                }
                elseif (isset($this->route['var']['id'])) {
                    $id = intval($this->route['var']['id']);
                }

                if ($id) {
                    $q = '
                    SELECT
                        audioRelease.id,
                        audioRelease.releaseName,
                        audioRelease.releasedOn,
                        audioRelease.updatedOn,
                        audioRelease.audioIDs,
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
                    WHERE audioRelease.id = :id;';

                    $v = array(
                        array('id', $id, SQLITE3_INTEGER),
                    );

                    $dump = $this->DB->querySingle($q, $v);

                    if ($dump) {
                        $data  = $dump;
                        $data['artist'] = $this->getArtistByID(jdec($data['artistIDs']));
                        $data['audioIDs'] = jdec($data['audioIDs']);
                        $data['tracklist'] = $this->getAudioByID($data['audioIDs']);
                        $data['trackCount'] = count($data['tracklist']);
                        $data['description'] = $this->parseLazyInput($data['description']);
                        $data['credits'] = jdec($data['credits']);
                        $data['thanks'] = jdec($data['thanks']);
                        $data['relatedMedia'] = jdec($data['relatedMedia']);
                    }
                }
                break;
        }

        return $data;
    }


    protected function getAudioFilter(): array {
        $filter = array();

        // all
        $filter[] = array(
            'All',
            $this->routeURL('music'),
            !in_array('freedl', $this->route['flag']) && !isset($this->route['var']['year']) && !isset($this->route['var']['type']),
        );

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

        // free to download
        $filter[] = array(
            'FreeDL',
            $this->routeURL('music/freedl'),
            in_array('freedl', $this->route['flag']),
        );

        // dj mixes link
        $filter[] = array(
            'DJ-Mixes&nearr;',
            '//mixcloud.com/lowtechman/uploads/?order=latest',
            null,
        );

        return $filter;
    }


    protected function getAudioByID(int|array $id): array {
        $data = array();

        $q = '
        SELECT
            id,
            audioName,
            audioRuntime,
            artistIDs,
            bandcampID,
            bandcampHost,
            bandcampSlug,
            spotifyHost,
            spotifySlug
        FROM audio
        WHERE id = :id;';

        if (is_int($id)) {
            $v = array(
                array('id', $id, SQLITE3_INTEGER),
            );
            $dump = $this->DB->querySingle($q, $v);
            if ($dump) {
                $dump['artist'] = $this->getArtistByID(jdec($dump['artistIDs']));
                $dump['audioRuntimeString'] = $this->secondsToString($dump['audioRuntime']);
                $dump['bandcampURL'] = ($dump['bandcampSlug']) ? sprintf('%s%s', $dump['bandcampHost'], $dump['bandcampSlug']) : null;
                $dump['spotifyURL'] = ($dump['spotifySlug']) ? sprintf('%s%s', $dump['spotifyHost'], $dump['spotifySlug']) : null;
                $data = $dump;
            }
        }

        if (is_array($id)) {
            foreach ($id as $v) {
                $v = array(
                    array('id', $v, SQLITE3_INTEGER),
                );
                $dump = $this->DB->querySingle($q, $v);

                if ($dump) {
                    $dump['artist'] = $this->getArtistByID(jdec($dump['artistIDs']));
                    $dump['audioRuntimeString'] = $this->secondsToString($dump['audioRuntime']);
                    $dump['bandcampURL'] = ($dump['bandcampSlug']) ? sprintf('%s%s', $dump['bandcampHost'], $dump['bandcampSlug']) : null;
                    $dump['spotifyURL'] = ($dump['spotifySlug']) ? sprintf('%s%s', $dump['spotifyHost'], $dump['spotifySlug']) : null;
                    $data[] = $dump;
                }
            }
        }

        return $data;
    }


    protected function getArtistByID(int|array $id): array {
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


    /*
    static function getCollabArtist(array $audioArtist): array {
        $artist = array();

        if (count($audioArtist) > 1) {
            foreach ($audioArtist as $v) {
                if ($v['id'] != 1) {
                    $artist[] = $v['artistName'];
                }
            }
        }

        return $artist;
    }
    */


    protected function getPlanet420(string $mode, array $kwargs=array()): array {
        $data = array();

        $sessionNum = null;
        if (isset($kwargs['num'])) {
            $sessionNum = intval($kwargs['num']);
        }
        elseif (in_array('session', $this->route['flag']) && isset($this->route['var']['num'])) {
            $sessionNum = intval($this->route['var']['num']);
        }

        switch ($mode) {
            case 'archiveList':
                $q = '
                SELECT
                    p420session.sessionNum, p420session.sessionDate, p420session.sessionDur, p420session.mixcloudHost, p420session.mixcloudSlug,
                    COUNT(p420trackHistory.sessionNum) AS trackCount
                FROM
                    p420session
                JOIN
                    p420trackHistory ON p420trackHistory.sessionNum = p420session.sessionNum
                GROUP BY
                    p420session.sessionNum
                ORDER BY
                    p420session.sessionNum DESC;
                ';

                $data = $this->DB->query($q);
                break;

            case 'sessionByID':
                if ($sessionNum) {
                    $q = '
                    SELECT
                        p420session.sessionNum, p420session.sessionDate, p420session.sessionDur, p420session.mixcloudHost, p420session.mixcloudSlug,
                        COUNT(p420trackHistory.sessionNum) AS trackCount
                    FROM
                        p420session
                    JOIN
                        p420trackHistory ON p420trackHistory.sessionNum = p420session.sessionNum
                    WHERE
                        p420session.sessionNum = :sessionNum
                    GROUP BY
                        p420session.sessionNum;
                    ';

                    $v = array(
                        array('sessionNum', $sessionNum, SQLITE3_INTEGER),
                    );

                    $data = $this->DB->querySingle($q, $v);
                }
                break;

            case 'sessionTracklist':
                if ($sessionNum) {
                    $q = '
                    SELECT
                        artistName, trackName, timeStart
                    FROM
                        p420trackHistory
                    WHERE
                        sessionNum = :sessionNum
                    ORDER BY
                        timeStart ASC;
                    ';

                    $v = array(
                        array('sessionNum', $sessionNum, SQLITE3_INTEGER),
                    );

                    $data = $this->DB->query($q, $v);
                }
                break;

            case 'artistList':
                if (in_array('artists', $this->route['flag'])) {
                    $q = '
                    SELECT
                        DISTINCT LOWER(artistName) AS artistNameLC, artistName
                    FROM
                        p420trackHistory
                    ORDER BY
                        artistNameLC ASC;
                    ';

                    $data = $this->DB->query($q);
                }
                break;

        }

        return $data;
    }


    protected function getVisual(string $mode, array $kwargs=array()): array {
        $data = array();

        switch ($mode) {

            case 'list':
                $q = '
                SELECT
                    id, createdOn, visualName, tags, media
                FROM
                    visual
                ORDER BY
                    id DESC;
                ';

                $r = $this->DB->query($q);

                if ($r) {
                    foreach ($r as $k => $v) {
                        $r[$k]['tags'] = jdec($v['tags']);
                        $r[$k]['media'] = jdec($v['media']);
                    }

                    $data = $r;
                }
                break;

            case 'byID':
                $id = null;
                if (isset($kwargs['id'])) {
                    $id = intval($kwargs['id']);
                }
                elseif (isset($this->route['var']['id'])) {
                    $id = intval($this->route['var']['id']);
                }

                if ($id) {
                    $q = '
                    SELECT
                        id, createdOn, visualName, description, tags, media
                    FROM
                        visual
                    WHERE
                        id = :id;';

                    $v = array(
                        array('id', $id, SQLITE3_INTEGER),
                    );

                    $dump = $this->DB->querySingle($q, $v);

                    if ($dump) {
                        $dump['tags'] = jdec($dump['tags']);
                        $dump['media'] = jdec($dump['media']);
                        $data = $dump;
                    }
                }
                break;
        }

        return $data;
    }


    protected function getStuff(string $mode, array $kwargs=array()): array {
        $data = array();

        switch ($mode) {
            case 'list':
                $q = '
                SELECT
                    id, stuffName, LOWER(stuffName) AS stuffNameLC, media
                FROM
                    stuff
                ORDER BY
                    stuffNameLC ASC;
                ';

                $dump = $this->DB->query($q);

                if ($dump) {
                    foreach ($dump as $k => $v) {
                        $dump[$k]['media'] = jdec($v['media']);
                    }

                    $data = $dump;
                }
                break;

            case 'byID':
                $id = null;
                if (isset($kwargs['id'])) {
                    $id = intval($kwargs['id']);
                }
                elseif (isset($this->route['var']['id'])) {
                    $id = intval($this->route['var']['id']);
                }

                if ($id) {
                    $q = '
                    SELECT
                        id, stuffName, description, media
                    FROM
                        stuff
                    WHERE
                        id = :id;';

                    $v = array(
                        array('id', $id, SQLITE3_INTEGER),
                    );

                    $dump = $this->DB->querySingle($q, $v);

                    if ($dump) {
                        $dump['media'] = jdec($dump['media']);
                        $data = $dump;
                    }
                }
                break;
        }

        return $data;
    }


    protected function getExit(string $mode, array $kwargs=array()): array {
        $data = array();

        switch ($mode) {
            case 'list':
                $q = '
                SELECT
                    id, linkText, LOWER(linkText) AS linkTextLC, url
                FROM
                    exit
                ORDER BY
                    linkTextLC ASC;
                ';

                $dump = $this->DB->query($q);

                if ($dump) {
                    $data = $dump;
                }
                break;

        }

        return $data;
    }


    protected function parseLazyInput(string $input): string|array|null {
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


    static protected function secondsToString(int $seconds): string {
        $s = max(0, $seconds);

        $dur = array(
            'd' => floor($s / (3600 * 24)),
            'h' => floor($s % (3600 * 24) / 3600),
            'm' => floor($s % 3600 / 60),
            's' => floor($s % 60),
        );

        if ($dur['d'] > 0) {
            return sprintf('%d:%02d:%02d:%02d', $dur['d'], $dur['h'], $dur['m'], $dur['s']);
        }

        if ($dur['h'] > 0) {
            return sprintf('%d:%02d:%02d', $dur['h'], $dur['m'], $dur['s']);
        }

        return sprintf('%d:%02d', $dur['m'], $dur['s']);
    }
}
