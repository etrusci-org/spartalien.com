<?php
declare(strict_types=1);
namespace s9com;



class Mixcloud
{
    public function __construct(
        public string $cache_dir = __DIR__,
        public int $cache_ttl = 86400,
        public string $api_base_url = 'https://api.mixcloud.com',
        public float $api_request_delay = 2.0,
        public int $api_paging_limit = 100,
        private null|array $buffer = null,
    ) {}


    public function fetch_cloudcasts(string $user_name): array
    {
        $this->reset_buffer();
        $url = sprintf('%1$s/%2$s/cloudcasts/?limit=%3$s&offset=0', $this->api_base_url, $user_name, $this->api_paging_limit);
        $cacheFile = sprintf('%1$s/mixcloud-%2$s-cloudcasts.json', $this->cache_dir, $user_name);
        return $this->fetch_data($url, $cacheFile);
    }


    public function fetch_comments(string $user_name): array
    {
        $this->reset_buffer();
        $url = sprintf('%1$s/%2$s/comments/?limit=%3$s&offset=0', $this->api_base_url, $user_name, $this->api_paging_limit);
        $cacheFile = sprintf('%1$s/mixcloud-%2$s-comments.json', $this->cache_dir, $user_name);
        return $this->fetch_data($url, $cacheFile);
    }


    public function fetch_favorites(string $user_name): array
    {
        $this->reset_buffer();
        $url = sprintf('%1$s/%2$s/favorites/?limit=%3$s&offset=0', $this->api_base_url, $user_name, $this->api_paging_limit);
        $cacheFile = sprintf('%1$s/mixcloud-%2$s-favorites.json', $this->cache_dir, $user_name);
        return $this->fetch_data($url, $cacheFile);
    }


    public function fetch_feed(string $user_name): array
    {
        $this->reset_buffer();
        $url = sprintf('%1$s/%2$s/feed/?limit=%3$s&offset=0', $this->api_base_url, $user_name, $this->api_paging_limit);
        $cacheFile = sprintf('%1$s/mixcloud-%2$s-feed.json', $this->cache_dir, $user_name);
        return $this->fetch_data($url, $cacheFile);
    }


    public function fetch_followers(string $user_name): array
    {
        $this->reset_buffer();
        $url = sprintf('%1$s/%2$s/followers/?limit=%3$s&offset=0', $this->api_base_url, $user_name, $this->api_paging_limit);
        $cacheFile = sprintf('%1$s/mixcloud-%2$s-followers.json', $this->cache_dir, $user_name);
        return $this->fetch_data($url, $cacheFile);
    }


    public function fetch_following(string $user_name): array
    {
        $this->reset_buffer();
        $url = sprintf('%1$s/%2$s/following/?limit=%3$s&offset=0', $this->api_base_url, $user_name, $this->api_paging_limit);
        $cacheFile = sprintf('%1$s/mixcloud-%2$s-following.json', $this->cache_dir, $user_name);
        return $this->fetch_data($url, $cacheFile);
    }


    public function fetch_listens(string $user_name): array
    {
        $this->reset_buffer();
        $url = sprintf('%1$s/%2$s/listens/?limit=%3$s&offset=0', $this->api_base_url, $user_name, $this->api_paging_limit);
        $cacheFile = sprintf('%1$s/mixcloud-%2$s-listens.json', $this->cache_dir, $user_name);
        return $this->fetch_data($url, $cacheFile);
    }


    public function fetch_playlists(string $user_name): array
    {
        $this->reset_buffer();
        $url = sprintf('%1$s/%2$s/playlists/?limit=%3$s&offset=0', $this->api_base_url, $user_name, $this->api_paging_limit);
        $cacheFile = sprintf('%1$s/mixcloud-%2$s-playlists.json', $this->cache_dir, $user_name);
        return $this->fetch_data($url, $cacheFile);
    }


    public function fetch_show(string $user_name, string $show_slug): array
    {
        $this->reset_buffer();
        $api_url = sprintf('%1$s/%2$s/%3$s/?metadata=1', $this->api_base_url, $user_name, $show_slug);
        $cache_file = sprintf('%1$s/mixcloud-%2$s-show-%3$s.json', $this->cache_dir, $user_name, $show_slug);
        return $this->fetch_data($api_url, $cache_file);
    }


    public function fetch_user(string $user_name): array
    {
        $this->reset_buffer();
        $api_url = sprintf('%1$s/%2$s/?metadata=1', $this->api_base_url, $user_name);
        $cache_file = sprintf('%1$s/mixcloud-%2$s-user.json', $this->cache_dir, $user_name);
        return $this->fetch_data($api_url, $cache_file);
    }


    private function reset_buffer(): void
    {
        $this->buffer = null;
    }


    private function fetch_data(string $api_url, string $cache_file): array
    {
        $this->buffer ??= [
            'next_request_on' => microtime(true),
            'data' => [],
        ];

        if (!file_exists($cache_file) || time() - filemtime($cache_file) > $this->cache_ttl) {
            $curl = curl_init($api_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            if ($this->buffer['next_request_on'] > microtime(true)) {
                time_sleep_until($this->buffer['next_request_on']);
            }

            $api_data = curl_exec($curl);
            $this->buffer['next_request_on'] = microtime(true) + $this->api_request_delay;

            if (curl_getinfo($curl, CURLINFO_RESPONSE_CODE) != 200) {
                printf("ERROR\nURL: %s\nRESPONSE: %s\n%s\n", $api_url, $api_data, str_repeat('-', 100));
                return [];
            }

            $api_data = json_decode($api_data, true);

            $this->buffer['data'] = array_merge($this->buffer['data'], $api_data['data'] ?? $api_data);

            if (isset($api_data['paging']) && isset($api_data['paging']['next'])) {
                $this->fetch_data($api_data['paging']['next'], $cache_file);
            }
            else if ($this->cache_ttl >= 0) {
                file_put_contents($cache_file, json_encode($this->buffer['data'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), LOCK_EX);
            }
        }
        else {
            $api_data = file_get_contents($cache_file);
            $api_data = json_decode($api_data, true);
            $this->buffer['data'] = $api_data;
        }

        return $this->buffer['data'] ?? [];
    }
}
