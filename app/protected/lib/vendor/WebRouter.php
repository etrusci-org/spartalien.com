<?php
declare(strict_types=1);


/**
 * URL query string parser for the lazy.
 *
 * The idea is to provide a syntax for generating and reading your web app routes.
 * It's hard sometimes doing this with individual query string variables. With this
 * approach you'll have all the needed data in an array ready to use.
 */
class WebRouter {
    public $requestSource = 'get+post';
    public $requestKey = 'r';
    public $defaultRoute = array(
        'time' => null,
        'request'=> null,
        'node' => 'index',
        'var' => array(),
        'flag' => array(),
    );

    /**
     * Parse current or custom route.
     *
     * @param array $array=null  Custom route array.
     * @param bool $sort=true  Whether to sort the route contents.
     * @return array  Parsed route.
     */
    public function parseRoute(array $array=null, bool $sort=true): array {
        $route = $this->defaultRoute;
        $route['time'] = time();

        switch ($this->requestSource) {
            case 'get':
                $requestData = $_GET;
                break;

            case 'post';
                $requestData = $_POST;
                break;

            case 'get+post';
                $requestData = array_merge($_GET, $_POST);
                break;

            default:
                $requestData = $_GET;
        }

        if (!$array) {
            $request = array_key_exists($this->requestKey, $requestData) ? $requestData[$this->requestKey] : '';
        }
        else {
            $request = array_key_exists($this->requestKey, $array) ? $array[$this->requestKey] : '';
        }

        $route['request'] = trim($request);

        if (!$request) {
            return $route;
        }

        $dump = explode('/', $request, 2);

        $route['node'] = count($dump) > 0 ? trim($dump[0]) : '';

        if (count($dump) > 1) {
            $dump = explode('/', $dump[1]);
            foreach ($dump as $v) {
                $v = trim($v);
                if (stristr($v, ':')) {
                    $v = explode(':', $v);
                    if (count($v) == 2) {
                        $v[0] = trim($v[0]);
                        $v[1] = trim($v[1]);
                        if (!empty($v[0]) && !empty($v[1]) && !array_key_exists($v[0], $route['var'])) {
                            $route['var'][$v[0]] = $v[1];
                        }
                    }
                }
                else {
                    if (!empty($v) && !in_array($v, $route['flag'])) {
                        $route['flag'][] = $v;
                    }
                }
            }
        }

        if ($sort) {
            ksort($route['var']);
            sort($route['flag']);
        }

        // var_dump($route);
        return $route;
    }
}
