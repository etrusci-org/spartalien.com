<?php
declare(strict_types=1);


class App extends WebApp {
    public function validateRequest(): void {
        // set node and response code to 404 if invalid request
        if (!in_array(trim($this->route['request'], ' /'), VALID_REQUESTS)) {
            $this->route['node'] = '404';
            http_response_code(404);
        }
    }


    protected function getSearchResult(int $queryLengthMin = 3, int $queryLengthMax = 30): array {
        $query = (isset($_POST['query'])) ? strtolower(trim($_POST['query'])) : null;
        $cacheFile = null;
        $searchResult = [
            'query' => null,
            'resultCountTotal' => 0,
            'result' => [],
        ];

        if (isset($_POST['search']) &&
            isset($query) &&
            !empty($query) &&
            strlen($query) >= $queryLengthMin &&
            strlen($query) <= $queryLengthMax
        ) {
            $searchResult['query'] = $query;
            $cacheFile = sprintf('%s/searchresult-%s.json', $this->conf['cacheDir'], hash('ripemd160', $query));

            if ($this->conf['cachingEnabled'] && file_exists($cacheFile)) { // no ttl needed since we just delete the cache when content changes
                $searchResult = jsonDecode(file_get_contents($cacheFile));
            }
            else {
                // audioRelease
                $q = '
                SELECT
                    audioRelease.id,
                    audioRelease.audioIDs,
                    audioRelease.releaseName,
                    audioRelease.bandcampID,
                    audioRelease.bandcampHost,
                    audioRelease.bandcampSlug,
                    audioRelease.spotifyHost,
                    audioRelease.spotifySlug,
                    audioReleaseType.typeName AS releaseType
                FROM
                    audioRelease
                LEFT JOIN
                    audioReleaseType ON audioReleaseType.id = audioRelease.audioReleaseTypeID
                WHERE
                    LOWER(audioRelease.releaseName) LIKE :query
                ORDER
                    BY LOWER(audioRelease.releaseName) ASC;';
                $v = [
                    ['query', sprintf('%%%1$s%%', $query), SQLITE3_TEXT],
                ];
                $r = $this->DB->query($q, $v);
                if ($r) {
                    foreach ($r as $k => $v) {
                        $r[$k]['trackCount'] = count(jsonDecode($v['audioIDs']));
                    }
                    $searchResult['result']['audioRelease']['resultCount'] = count($r);
                    $searchResult['result']['audioRelease']['items'] = $r;
                }

                // audio
                $q = '
                SELECT
                    id,
                    audioName,
                    bandcampID,
                    bandcampHost,
                    bandcampSlug,
                    spotifyHost,
                    spotifySlug
                FROM
                    audio
                WHERE
                    LOWER(audioName) LIKE :query
                ORDER BY
                    LOWER(audioName) ASC;';
                $v = [
                    ['query', sprintf('%%%1$s%%', $query), SQLITE3_TEXT],
                ];
                $r = $this->DB->query($q, $v);
                if ($r) {
                    $searchResult['result']['audio']['resultCount'] = count($r);
                    $searchResult['result']['audio']['items'] = $r;
                }

                // visual
                $q = '
                SELECT
                    id, visualName
                FROM
                    visual
                WHERE
                    LOWER(visualName) LIKE :query
                ORDER BY
                    LOWER(visualName) ASC;';
                $v = [
                    ['query', sprintf('%%%1$s%%', $query), SQLITE3_TEXT],
                ];
                $r = $this->DB->query($q, $v);
                if ($r) {
                    $searchResult['result']['visual']['resultCount'] = count($r);
                    $searchResult['result']['visual']['items'] = $r;
                }

                // stuff
                $q = '
                SELECT
                    id, stuffName
                FROM
                    stuff
                WHERE
                    LOWER(stuffName) LIKE :query
                ORDER BY
                    LOWER(stuffName) ASC;';
                $v = [
                    ['query', sprintf('%%%1$s%%', $query), SQLITE3_TEXT],
                ];
                $r = $this->DB->query($q, $v);
                if ($r) {
                    $searchResult['result']['stuff']['resultCount'] = count($r);
                    $searchResult['result']['stuff']['items'] = $r;
                }

                // news
                $q = '
                SELECT
                    id,
                    postedOn,
                    items
                FROM
                    news
                WHERE
                    LOWER(items) LIKE :query
                ORDER BY
                    postedOn DESC;';
                $v = [
                    ['query', sprintf('%%%1$s%%', $query), SQLITE3_TEXT],
                ];
                $r = $this->DB->query($q, $v);
                if ($r) {
                    foreach ($r as $k => $v) {
                        $r[$k]['items'] = jsonDecode($v['items']);
                    }
                    $searchResult['result']['news']['resultCount'] = count($r);
                    $searchResult['result']['news']['items'] = $r;
                }

                // planet420
                $q = '
                SELECT DISTINCT
                    sessionNum,
                    timeStart,
                    artistName,
                    trackName
                FROM
                    p420trackHistory
                WHERE
                    LOWER(artistName) LIKE :query OR
                    LOWER(trackName) LIKE :query
                ORDER BY
                    LOWER(artistName) ASC, LOWER(trackName) ASC;';
                $v = [
                    ['query', sprintf('%%%1$s%%', $query), SQLITE3_TEXT],
                ];
                $r = $this->DB->query($q, $v);
                if ($r) {
                    $searchResult['result']['planet420']['resultCount'] = count($r);
                    $searchResult['result']['planet420']['items'] = $r;
                }
            }
        }

        $searchResult['resultCountTotal'] = array_sum(array_map(function(array $v): int {
            return $v['resultCount'];
        }, $searchResult['result']));

        if ($this->conf['cachingEnabled'] && $cacheFile && $searchResult['resultCountTotal'] > 0) {
            file_put_contents($cacheFile, jsonEncode($searchResult, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), LOCK_EX);
        }

        return $searchResult;
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
        $data = [];

        switch ($mode) {
            case 'list':
                $q = '
                SELECT
                    id,
                    postedOn,
                    items
                FROM news
                ORDER BY postedOn DESC;';

                $dump = $this->DB->query($q);

                if ($dump) {
                    $data = $dump;
                    foreach ($data as $k => $v) {
                        $data[$k]['items'] = jsonDecode($v['items']);
                    }
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

                    $v = [
                        ['id', $this->route['var']['id'], SQLITE3_TEXT],
                    ];

                    $dump = $this->DB->querySingle($q, $v);
                    if ($dump) {
                        $data = $dump;
                        $data['items'] = jsonDecode($data['items']);
                    }
                }
                break;
        }

        return $data;
    }


    protected function getAudio(string $mode, /* array $kwargs=[] */): array {
        $data = [];

        switch ($mode) {
            case 'releaseList':
                $w = '';
                $v = [];

                // type
                if (isset($this->route['var']['type'])) {
                    $w = 'WHERE lower(audioReleaseType.typeName) = :type';
                    $v[] = ['type', strtolower($this->route['var']['type']), SQLITE3_TEXT];
                }

                // collab
                if (in_array('collab', $this->route['flag'])) {
                    $w = 'WHERE audioRelease.artistIDs != \'[1]\'';
                }

                // free to download
                if (in_array('freedl', $this->route['flag'])) {
                    $w = 'WHERE audioRelease.freeToDownload = 1';
                }

                // year
                if (isset($this->route['var']['year'])) {
                    $w = 'WHERE substr(audioRelease.releasedOn, 1, 4) = :year OR substr(audioRelease.updatedOn, 1, 4) = :year';
                    $v[] = ['year', $this->route['var']['year'], SQLITE3_TEXT];
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

                $dump = $this->DB->query($q, $v);

                if ($dump) {
                    $data = $dump;
                    foreach ($data as $k => $v) {
                        $data[$k]['artist'] = $this->getArtistByID(jsonDecode($v['artistIDs']));
                        $data[$k]['audioIDs'] = jsonDecode($v['audioIDs']);
                        $data[$k]['trackCount'] = count($data[$k]['audioIDs']);
                    }
                }
                break;

            case 'releaseByID':
                // $id = null;
                // if (isset($kwargs['id'])) {
                //     $id = intval($kwargs['id']);
                // }
                // elseif (isset($this->route['var']['id'])) {
                //     $id = intval($this->route['var']['id']);
                // }

                // if ($id) {
                if (isset($this->route['var']['id'])) {
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

                    $v = [
                        ['id', $this->route['var']['id'], SQLITE3_INTEGER],
                    ];

                    $dump = $this->DB->querySingle($q, $v);

                    if ($dump) {
                        $data  = $dump;
                        $data['artist'] = $this->getArtistByID(jsonDecode($data['artistIDs']));
                        $data['audioIDs'] = jsonDecode($data['audioIDs']);
                        $data['tracklist'] = $this->getAudioByID($data['audioIDs']);
                        $data['trackCount'] = count($data['tracklist']);
                        $data['description'] = $this->parseLazyInput($data['description']);
                        $data['credits'] = jsonDecode($data['credits']);
                        $data['thanks'] = jsonDecode($data['thanks']);
                        $data['relatedMedia'] = jsonDecode($data['relatedMedia']);
                    }
                }
                break;
        }

        return $data;
    }


    protected function getAudioFilter(): array {
        $filter = [];

        // all
        $filter[] = [
            'All',
            $this->routeURL('music'),
            (empty($this->route['var']) && empty($this->route['flag'])) || isset($this->route['var']['id']),
        ];

        // types
        $q = '
        SELECT DISTINCT
            audioReleaseType.typeName AS releaseType
        FROM audioRelease
        LEFT JOIN audioReleaseType ON audioReleaseType.id = audioRelease.audioReleaseTypeID
        ORDER BY audioReleaseType.typeName ASC;';
        $dump = $this->DB->query($q);
        if ($dump) {
            foreach ($dump as $v) {
                $v['releaseType'] = str_replace('Digital ', '', $v['releaseType']);
                $filter[] = [
                    $v['releaseType'],
                    $this->routeURL('music/type:%s', [strtolower($v['releaseType'])]),
                    isset($this->route['var']['type']) && strtolower($this->route['var']['type']) == strtolower($v['releaseType']),
                ];
            }

            // collab
            $filter[] = [
                'Collab',
                $this->routeURL('music/collab'),
                in_array('collab', $this->route['flag']),
            ];

            // free to download
            $filter[] = [
                'FreeDL',
                $this->routeURL('music/freedl'),
                in_array('freedl', $this->route['flag']),
            ];

            // years
            $q = '
            SELECT DISTINCT
                substr(releasedOn, 1, 4) AS year
            FROM audioRelease
            WHERE releasedOn IS NOT NULL
            ORDER BY releasedOn DESC;';
            $dump = $this->DB->query($q);
            if ($dump) {
                foreach ($dump as $v) {
                    $filter[] = [
                        $v['year'],
                        $this->routeURL('music/year:%s', [$v['year']]),
                        isset($this->route['var']['year']) && $this->route['var']['year'] == $v['year'],
                    ];
                }
            }

            // dj mixes
            $filter[] = [
                'DJ Mixes',
                $this->routeURL('djmixes'),
                null,
            ];
        }

        return $filter;
    }


    protected function getAudioByID(int|array $id): array {
        $data = [];

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
            $v = [
                ['id', $id, SQLITE3_INTEGER],
            ];
            $dump = $this->DB->querySingle($q, $v);
            if ($dump) {
                $dump['artist'] = $this->getArtistByID(jsonDecode($dump['artistIDs']));
                $dump['audioRuntimeString'] = $this->secondsToString($dump['audioRuntime']);
                $dump['bandcampURL'] = ($dump['bandcampSlug']) ? sprintf('%s%s', $dump['bandcampHost'], $dump['bandcampSlug']) : null;
                $dump['spotifyURL'] = ($dump['spotifySlug']) ? sprintf('%s%s', $dump['spotifyHost'], $dump['spotifySlug']) : null;
                $data = $dump;
            }
        }

        if (is_array($id)) {
            foreach ($id as $v) {
                $v = [
                    ['id', $v, SQLITE3_INTEGER],
                ];
                $dump = $this->DB->querySingle($q, $v);

                if ($dump) {
                    $dump['artist'] = $this->getArtistByID(jsonDecode($dump['artistIDs']));
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
        $data = [];

        $q = '
        SELECT
            id,
            artistName,
            artistURL
        FROM artist
        WHERE id = :id;';

        if (is_int($id)) {
            $v = [
                ['id', $id, SQLITE3_INTEGER],
            ];
            $dump = $this->DB->querySingle($q, $v);
            if ($dump) {
                $data = $dump;
            }
        }

        if (is_array($id)) {
            foreach ($id as $i) {
                $v = [
                    ['id', $i, SQLITE3_INTEGER],
                ];
                $dump = $this->DB->querySingle($q, $v);
                if ($dump) {
                    $data[] = $dump;
                }
            }
        }

        return $data;
    }


    protected function getPlanet420(string $mode, /* array $kwargs=[] */): array {
        $data = [];

        // $sessionNum = null;
        // if (isset($kwargs['num'])) {
        //     $sessionNum = intval($kwargs['num']);
        // }
        // elseif (in_array('session', $this->route['flag']) && isset($this->route['var']['num'])) {
        //     $sessionNum = intval($this->route['var']['num']);
        // }
        $sessionNum = null;
        if (in_array('session', $this->route['flag']) && isset($this->route['var']['num'])) {
            $sessionNum = intval($this->route['var']['num']);
        }

        switch ($mode) {
            case 'archiveList':
                $q = '
                SELECT
                    p420session.sessionNum,
                    p420session.sessionDate,
                    p420session.sessionDur,
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

                $dump = $this->DB->query($q);
                if ($dump) {
                    $data = $dump;
                }
                break;

            case 'sessionByID':
                if ($sessionNum) {
                    $q = '
                    SELECT
                        p420session.sessionNum,
                        p420session.sessionDate,
                        p420session.sessionDur,
                        p420session.mixcloudHost,
                        p420session.mixcloudSlug,
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

                    $v = [
                        ['sessionNum', $sessionNum, SQLITE3_INTEGER],
                    ];

                    $dump = $this->DB->querySingle($q, $v);
                    if ($dump) {
                        $data = $dump;
                    }
                }
                break;

            case 'sessionTracklist':
                if ($sessionNum) {
                    $q = '
                    SELECT
                        artistName,
                        trackName,
                        timeStart
                    FROM
                        p420trackHistory
                    WHERE
                        sessionNum = :sessionNum
                    ORDER BY
                        timeStart ASC;
                    ';

                    $v = [
                        ['sessionNum', $sessionNum, SQLITE3_INTEGER],
                    ];

                    $dump = $this->DB->query($q, $v);
                    if ($dump) {
                        $data = $dump;
                    }
                }
                break;

            case 'artistList':
                if (in_array('artists', $this->route['flag'])) {
                    $q = '
                    SELECT
                        DISTINCT LOWER(artistName) AS artistNameLC,
                        artistName
                    FROM
                        p420trackHistory
                    ORDER BY
                        artistNameLC ASC;
                    ';

                    $dump = $this->DB->query($q);
                    if ($dump) {
                        $data = $dump;
                    }
                }
                break;

        }

        return $data;
    }


    protected function getVisual(string $mode, /* array $kwargs=[] */): array {
        $data = [];

        switch ($mode) {

            case 'list':
                $q = '
                SELECT
                    id,
                    createdOn,
                    visualName,
                    tags,
                    media
                FROM
                    visual
                ORDER BY
                    id DESC;
                ';

                $r = $this->DB->query($q);

                if ($r) {
                    foreach ($r as $k => $v) {
                        $r[$k]['tags'] = jsonDecode($v['tags']);
                        $r[$k]['media'] = jsonDecode($v['media']);
                    }

                    $data = $r;
                }
                break;

            case 'byID':
                // $id = null;
                // if (isset($kwargs['id'])) {
                //     $id = intval($kwargs['id']);
                // }
                // elseif (isset($this->route['var']['id'])) {
                //     $id = intval($this->route['var']['id']);
                // }
                // if ($id) {
                if (isset($this->route['var']['id'])) {
                    $q = '
                    SELECT
                        id,
                        createdOn,
                        visualName,
                        description,
                        tags,
                        media
                    FROM
                        visual
                    WHERE
                        id = :id;';

                    $v = [
                        ['id', $this->route['var']['id'], SQLITE3_INTEGER],
                    ];

                    $dump = $this->DB->querySingle($q, $v);

                    if ($dump) {
                        $dump['tags'] = jsonDecode($dump['tags']);
                        $dump['media'] = jsonDecode($dump['media']);
                        $data = $dump;
                    }
                }
                break;
        }

        return $data;
    }


    protected function getStuff(string $mode, /* array $kwargs=[] */): array {
        $data = [];

        switch ($mode) {
            case 'list':
                $q = '
                SELECT
                    id,
                    stuffName,
                    LOWER(stuffName) AS stuffNameLC,
                    media
                FROM
                    stuff
                ORDER BY
                    stuffNameLC ASC;
                ';

                $dump = $this->DB->query($q);

                if ($dump) {
                    foreach ($dump as $k => $v) {
                        $dump[$k]['media'] = jsonDecode($v['media']);
                    }

                    $data = $dump;
                }
                break;

            case 'byID':
                // $id = null;
                // if (isset($kwargs['id'])) {
                //     $id = intval($kwargs['id']);
                // }
                // elseif (isset($this->route['var']['id'])) {
                //     $id = intval($this->route['var']['id']);
                // }

                // if ($id) {
                if (isset($this->route['var']['id'])) {
                    $q = '
                    SELECT
                        id,
                        stuffName,
                        description,
                        media
                    FROM
                        stuff
                    WHERE
                        id = :id;';

                    $v = [
                        ['id', $this->route['var']['id'], SQLITE3_INTEGER],
                    ];

                    $dump = $this->DB->querySingle($q, $v);

                    if ($dump) {
                        $dump['media'] = jsonDecode($dump['media']);
                        $data = $dump;
                    }
                }
                break;
        }

        return $data;
    }


    protected function getExit(string $mode): array {
        $data = [];

        switch ($mode) {
            case 'list':
                $q = '
                SELECT
                    id,
                    linkText,
                    LOWER(linkText) AS linkTextLC,
                    url
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
        $patterns = [
            '/\n/', // linefeed
            '/\[b\](.*?)\[\/b\]/', // [b]bold[/b]
            '/\[i\](.*?)\[\/i\]/', // [i]italic[/i]
            '/\[url=(.*?)\](.*?)\[\/url\]/', // [url=link_url]link_text[/url]
            '/\[route=(.*?)\](.*?)\[\/route\]/', // [route=route_request]link_text[/route]
        ];

        $replacements = [
            '<br>',
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<a href="$1" rel="nofollow">$2</a>',
            sprintf('<a href="%1$s">%2$s</a>', $this->routeURL('$1'), '$2'),
        ];

        return preg_replace($patterns, $replacements, $input);
    }


    static protected function secondsToString(int $seconds): string {
        $s = max(0, $seconds);

        $dur = [
            'd' => floor($s / (3600 * 24)),
            'h' => floor($s % (3600 * 24) / 3600),
            'm' => floor($s % 3600 / 60),
            's' => floor($s % 60),
        ];

        if ($dur['d'] > 0) {
            return sprintf('%d:%02d:%02d:%02d', $dur['d'], $dur['h'], $dur['m'], $dur['s']);
        }

        if ($dur['h'] > 0) {
            return sprintf('%d:%02d:%02d', $dur['h'], $dur['m'], $dur['s']);
        }

        return sprintf('%d:%02d', $dur['m'], $dur['s']);
    }
}
