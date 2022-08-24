<?php
// ----------------
// WORK IN PROGRESS
// ----------------
declare(strict_types=1);


/**
 * Get some Mixcloud data and cache it for later.
 */
class MixcloudData {
    public string $cacheDir = __DIR__; // Absolute path to the cache directory.
    public int $cacheTTL = 604_800; // Seconds until cached data files expire. 0=always remote data but store data also in cache file. -1=disable caching.
    public string $errorFile = __DIR__.'/mixcloud-error.log'; // Absolute path to the error log file.
    public float $requestDelay = 0.250; // Seconds to wait between remote API requests.
    public int $pagingLimit = 20; // How many items to request per page in a remote API request (for results with paging, e.g. cloudcasts).
    public string $baseURL = 'https://api.mixcloud.com'; // API base URL without trailing slash.
    public string $patternUserURL = '%1$s/%2$s/?metadata=1'; // API URL pattern for user. 1=baseURL, 2=user.
    public string $patternUserCacheFile = '%1$s/mixcloud-%2$s-user.json'; // Cache file pattern for user. 1=cacheDir, 2=user.
    public string $patternCloudcastsURL = '%1$s/%2$s/cloudcasts/?limit=%3$s&offset=0'; // API URL pattern for cloudcasts. 1=baseURL, 2=user, 3=pagingLimit.
    public string $patternCloudcastsCacheFile = '%1$s/mixcloud-%2$s-cloudcasts.json'; // Cache file pattern for cloudcasts. 1=cacheDir, 2=user.
    public string $patternShowURL = '%1$s/%2$s/%3$s/?metadata=1'; // API URL pattern for show. 1=baseURL, 2=user, 3=slug.
    public string $patternShowCacheFile = '%1$s/mixcloud-%2$s-show-%3$s.json'; // Cache file pattern for show. 1=cacheDir, 2=user, 3=slug.
    protected array $ram = []; // Temporary data storage used by methods.


    protected function getData(string $url, string $cacheFile, null|string $mergeKey = null): array {
        if (!file_exists($cacheFile) || time() - filemtime($cacheFile) > $this->cacheTTL) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            if (isset($this->ram['nextRequestOn']) && $this->ram['nextRequestOn'] >= microtime(true)) {
                time_sleep_until($this->ram['nextRequestOn']);
            }
            $data = curl_exec($curl);
            $this->ram['nextRequestOn'] = microtime(true) + $this->requestDelay;

            if (curl_getinfo($curl, CURLINFO_RESPONSE_CODE) != 200) {
                $errorMsg = sprintf("TIME: %s\nURL: %s\nRESPONSE: %s\n%s\n", date('Y-m-d H:i:s T'), $url, $data, str_repeat('-', 100));
                file_put_contents($this->errorFile, $errorMsg, FILE_APPEND | LOCK_EX);
                return [];
            }

            $data = json_decode($data, true);

            $this->ram['data'] = array_merge($this->ram['data'], ($mergeKey && isset($data[$mergeKey])) ? $data[$mergeKey] : $data);

            if (isset($data['paging']) && isset($data['paging']['next'])) {
                $this->getData($data['paging']['next'], $cacheFile, $mergeKey);
            }

            if ($this->cacheTTL >= 0) {
                file_put_contents($cacheFile, json_encode($this->ram['data'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT), LOCK_EX);
            }
        }
        else {
            $data = file_get_contents($cacheFile);
            $data = json_decode($data, true);
            $this->ram['data'] = $data;
        }

        return $this->ram['data'];
    }


    public function getUser(string $user): array {
        $this->ram['data'] = [];

        $url = sprintf($this->patternUserURL, $this->baseURL, $user);
        $cacheFile = sprintf($this->patternUserCacheFile, $this->cacheDir, $user);

        $data = $this->getData($url, $cacheFile);

        return $data;
    }


    public function getCloudcasts(string $user): array {
        $this->ram['data'] = [];

        $url = sprintf($this->patternCloudcastsURL, $this->baseURL, $user, $this->pagingLimit);
        $cacheFile = sprintf($this->patternCloudcastsCacheFile, $this->cacheDir, $user);

        $data = $this->getData($url, $cacheFile, 'data');

        return $data;
    }


    public function getShow(string $user, string $slug): array {
        $this->ram['data'] = [];

        $url = sprintf($this->patternShowURL, $this->baseURL, $user, $slug);
        $cacheFile = sprintf($this->patternShowCacheFile, $this->cacheDir, $user, $slug);

        $data = $this->getData($url, $cacheFile);

        return $data;
    }
}
