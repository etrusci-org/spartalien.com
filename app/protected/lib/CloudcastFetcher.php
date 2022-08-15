<?php
declare(strict_types=1);


class CloudcastFetcher {
    public array $result = array();
    protected string $apiURL = 'https://api.mixcloud.com/%1$s/cloudcasts/?limit=20&offset=0';
    protected string $user;
    protected int $pagingDelay; // microseconds


    public function __construct(string $user, int $pagingDelay = 100_000) {
        $this->user        = $user;
        $this->apiURL      = sprintf($this->apiURL, $user);
        $this->pagingDelay = $pagingDelay;
    }


    public function fetchAll(): void {
        $dump = file_get_contents($this->apiURL);
        $dump = json_decode($dump, true);

        $this->result = array_merge($this->result, $dump['data']);

        if (isset($dump['paging']) && isset($dump['paging']['next'])) {
            $this->apiURL = $dump['paging']['next'];
            usleep($this->pagingDelay);
            $this->fetchAll();
        }
    }
}
