<?php
$output = [
    '_api' => [
        'site_base_url' => $this->conf['site_url'],
        'api_endpoint_url' => $this->conf['site_url'].'api',
        'client_request' => '/'.$this->Router->route['request'],
    ],
];


if (!isset($this->Router->route['var']['get'])) {
    $output['_api']['paths'] = [
        '/get:releases',
        '/get:tracks',
        '/get:release:<RELEASE_ID>',
        '/get:track:<TRACK_ID>',
    ];
}
else {
    if ($this->Router->route['var']['get'] == 'track_list') {
        $output['track_list'] = $this->get_catalog_track_list();
    }

    if ($this->Router->route['var']['get'] == 'release_list') {
        $output['release_list'] = $this->get_rls_list();
    }

    if ($this->Router->route['var']['get'] == 'track') {
        $output['track'] = $this->get_track($this->Router->route['var']['id']);
    }

    if ($this->Router->route['var']['get'] == 'release') {
        $output['release'] = $this->get_rls($this->Router->route['var']['id']);
    }

    $output['_api']['data_baked_on'] = microtime(true);
}


print($this->_json_enc($output));
?>
