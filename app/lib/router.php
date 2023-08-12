<?php
declare(strict_types=1);
namespace s9com;


class Router
{
    public string $request_src = 'get';
    public string $request_key = 'route';
    public array  $route;
    public array  $valid_requests;
    public string $error_node = 'error404';
    public array  $default_route = [
        'time'    => null,
        'request' => null,
        'node'    => 'home',
        'var'     => [],
        'flag'    => [],
    ];


    public function __construct(array $valid_requests = [])
    {
        $this->route = $this->default_route;
        $this->valid_requests = $valid_requests;
    }


    public function parse_route(): void
    {
        $this->route['time'] = microtime(true);

        switch ($this->request_src) {
            case 'get':
                $request_data = $_GET;
                break;

            case 'post';
                $request_data = $_POST;
                break;

            case 'get+post';
                $request_data = array_merge($_GET, $_POST);
                break;

            default:
                $request_data = [];
        }

        $request = array_key_exists($this->request_key, $request_data) ? $request_data[$this->request_key] : '';

        $this->route['request'] = trim($request);

        if (!$request) {
            return;
        }

        $dump = explode('/', $request, 2);

        $this->route['node'] = count($dump) > 0 ? trim($dump[0]) : '';

        if (count($dump) > 1) {
            $dump = explode('/', $dump[1]);
            foreach ($dump as $v) {
                $v = trim($v);
                if (stristr($v, ':')) {
                    $v = explode(':', $v);
                    if (count($v) == 2) {
                        $v[0] = trim($v[0]);
                        $v[1] = trim($v[1]);
                        if (!empty($v[0]) && !empty($v[1]) && !array_key_exists($v[0], $this->route['var'])) {
                            $this->route['var'][$v[0]] = $v[1];
                        }
                    }
                }
                else {
                    if (!empty($v) && !in_array($v, $this->route['flag'])) {
                        $this->route['flag'][] = $v;
                    }
                }
            }
        }

        ksort($this->route['var']);
        sort($this->route['flag']);
    }


    public function validate_request(): void
    {
        $valid = false;

        // route patterns
        foreach ($this->valid_requests as $pattern) {
            if (preg_match($pattern, $this->route['request'])) {
                $valid = true;
                break;
            }
        }

        // default node
        if ($this->route['request'] == '') {
            $valid = true;
        }

        if (!$valid) {
            $this->route['node'] = $this->error_node;
            http_response_code(404);
        }
    }


    public function get_route_id(string $hash_algo = 'ripemd160'): string
    {
        $request_hash = [
            $this->route['node']
        ];

        foreach ($this->route['var'] as $k => $v) {
            $request_hash[] = sprintf('%s:%s', $k, $v);
        }

        $request_hash[] = implode('/', $this->route['flag']);

        return sprintf('route_%s_%s', $this->route['node'], hash($hash_algo, implode('/', $request_hash)));
    }
}
