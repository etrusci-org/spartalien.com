<?php
declare(strict_types=1);
namespace s9com;


class Core
{
    public function __construct(
        protected array $conf,
        protected array $version,
        protected Database $DB,
        protected Router $Router,
        protected Logger $Logger,
        protected ActiveVisitors $ActiveVisitors,
    ) {}


    public function render_output(?array $page_files = null, array $default_page_files = ['_header', '*node', '_footer']): void
    {
        $this->ActiveVisitors->log_activity();

        if (!$page_files) {
            $page_files = $default_page_files;
        }

        // Assume compiled and cached file paths based on current route
        $cache_id = $this->Router->get_route_id();

        if ($this->Router->route['node'] == $this->Router->error_node) {
            $compile_file = $this->conf['cache_dir'].'/compiled_'.$this->Router->error_node.'.php';
            $cache_file = $this->conf['cache_dir'].'/cached_'.$this->Router->error_node.'.php';
            $this->Logger->log('error 404 | request='.$this->Router->route['request'].' | '.$this->_get_client_log_info());
        }
        else {
            $compile_file = $this->conf['cache_dir'].'/compiled_'.$cache_id.'.php';
            $cache_file = $this->conf['cache_dir'].'/cached_'.$cache_id.'.php';
        }

        // Assume brain file path
        $brain_file = $this->conf['page_dir'].'/_brain.php';

        // Load fast if caching is disabled
        if ($this->conf['caching_ttl'] < 0) {
            $this->_render_fast($brain_file, $page_files);
            return;
        }

        // Or load from cache if still valid
        if (
            is_file($cache_file) &&
            (time() - filemtime($cache_file)) < $this->conf['caching_ttl']
        ) {
            $this->_render_from_cache($cache_file);
            return;
        }

        // Or bake cache if caching is enabled and there's none yet
        $this->_render_bake_and_output_cache($brain_file, $cache_id, $compile_file, $cache_file, $page_files);
    }


    protected function _render_fast(string $brain_file, array $page_files): void
    {
        ob_start();

        include $brain_file;

        foreach ($page_files as $v) {
            if ($v == '*node') {
                include $this->conf['page_dir'].'/'.$this->Router->route['node'].'.php';
            }
            else if ($v) {
                include $this->conf['page_dir'].'/'.$v.'.php';
            }
        }

        $buffer = ob_get_contents();
        $buffer = str_replace('{nocache}', '', $buffer);
        $buffer = str_replace('{/nocache}', '', $buffer);

        ob_end_clean();

        print($buffer);
    }


    protected function _render_from_cache(string $cache_file): void
    {
        include $cache_file;
    }


    protected function _render_bake_and_output_cache(string $brain_file, string $cache_id, string $compile_file, string $cache_file, array $page_files): void
    {
        ob_start();

        include $brain_file;

        // Load raw code
        $code = '';
        foreach ($page_files as $v) {
            if ($v == '*node') {
                $code .= file_get_contents($this->conf['page_dir'].'/'.$this->Router->route['node'].'.php');
            }
            else if ($v) {
                $code .= file_get_contents($this->conf['page_dir'].'/'.$v.'.php');
            }
        }

        // find nocache blocks in code and remember them
        preg_match_all('/{nocache}(.*?){\/nocache}/sm', $code, $m, PREG_PATTERN_ORDER);
        $nocache_blocks = [];
        if ($m) {
            foreach ($m[0] as $k => $v) {
                $nocache_blocks['nocache_'.$k.'_'.$cache_id] = [
                    'search' => $v,
                    'replace' => $m[1][$k],
                ];
            }
        }

        // Replace ncblocks with idstr
        foreach ($nocache_blocks as $block_id => $v) {
            $code = str_replace($v['search'], $block_id, $code);
        }

        // Store current code to file
        file_put_contents($compile_file, $code, LOCK_EX);

        // Run current code and buffer output
        include $compile_file;
        $buffer = ob_get_contents();
        ob_clean();

        // Replace idstr in current output buffer with ncblockcode
        foreach ($nocache_blocks as $block_id => $v) {
            $buffer = str_replace($block_id, $v['replace'], $buffer);
        }

        // Store current buffer to file
        file_put_contents($cache_file, $buffer, LOCK_EX);

        // Run current output buffer
        include $cache_file;

        // Turn off output buffering and send buffer
        ob_end_flush();
    }


    protected function get_page_title(string $sep = ' | '): string
    {
        // Full title if route is neither default node nor error404
        if (
            $this->Router->route['node'] != $this->Router->default_route['node']
            && $this->Router->route['node'] != $this->Router->error_node
        ) {
            $page_title = $this->conf['site_nav'][$this->Router->route['node']]['link_text'] ?? ucfirst($this->Router->route['node']);

            if ($this->Router->route['node'] == 'music' && isset($this->Router->route['var']['id'])) {
                $dump = $this->DB->query_single('SELECT name FROM rls WHERE id = :id LIMIT 1;', [['id', $this->Router->route['var']['id'], SQLITE3_INTEGER]]);
                $page_title = $dump['name'].$sep.$page_title;
            }

            if ($this->Router->route['node'] == 'catalog' && isset($this->Router->route['var']['id'])) {
                $dump = $this->DB->query_single('SELECT name FROM track WHERE id = :id LIMIT 1;', [['id', $this->Router->route['var']['id'], SQLITE3_INTEGER]]);
                $page_title = $dump['name'].$sep.$page_title;
            }

            if ($this->Router->route['node'] == 'visual' && isset($this->Router->route['var']['id'])) {
                $dump = $this->DB->query_single('SELECT name FROM visual WHERE id = :id LIMIT 1;', [['id', $this->Router->route['var']['id'], SQLITE3_INTEGER]]);
                $page_title = $dump['name'].$sep.$page_title;
            }

            if ($this->Router->route['node'] == 'physical' && isset($this->Router->route['var']['id'])) {
                $dump = $this->DB->query_single('SELECT name FROM phy WHERE id = :id LIMIT 1;', [['id', $this->Router->route['var']['id'], SQLITE3_INTEGER]]);
                $page_title = $dump['name'].$sep.$page_title;
            }

            if ($this->Router->route['node'] == 'planet420' && isset($this->Router->route['var']['session'])) {
                $dump = $this->DB->query_single('SELECT num FROM p420_session WHERE num = :num LIMIT 1;', [['num', $this->Router->route['var']['session'], SQLITE3_INTEGER]]);
                $page_title = 'Planet 420.'.$dump['num'].$sep.$page_title;
            }

            if ($this->Router->route['node'] == 'stuff' && isset($this->Router->route['var']['id'])) {
                $dump = $this->DB->query_single('SELECT name FROM stuff WHERE id = :id LIMIT 1;', [['id', $this->Router->route['var']['id'], SQLITE3_INTEGER]]);
                $page_title = $dump['name'].$sep.$page_title;
            }

            if ($this->Router->route['node'] == 'mention' && isset($this->Router->route['var']['id'])) {
                $dump = $this->DB->query_single('SELECT subject FROM mention WHERE id = :id LIMIT 1;', [['id', $this->Router->route['var']['id'], SQLITE3_INTEGER]]);
                $page_title = $dump['subject'].$sep.$page_title;
            }

            if ($this->Router->route['node'] == 'news' && isset($this->Router->route['var']['id'])) {
                $dump = $this->DB->query_single('SELECT pub_date FROM news WHERE id = :id LIMIT 1;', [['id', $this->Router->route['var']['id'], SQLITE3_INTEGER]]);
                $page_title = 'News from '.$dump['pub_date'].$sep.$page_title;
            }

            return $page_title.$sep.$this->conf['site_title'];
        }

        // Special title if route is error404
        if ($this->Router->route['node'] == $this->Router->error_node) {
            return 'Error 404'.$sep.$this->conf['site_title'];
        }

        // Only site title if we reach this line
        return $this->conf['site_title'];
    }


    protected function get_site_nav_html(string $sep = ' '): string
    {
        $dump = [];

        foreach ($this->conf['site_nav'] as $k => $v) {
            $dump[] = sprintf(
                '<a href="%1$s" title="%3$s" %4$s>%2$s</a>',
                $v['link'],
                $this->_hsc($v['link_text']),
                $this->_hsc($v['link_title']),
                ($this->Router->route['node'] == $k) ? ' class="active"' : '',
            );
        }

        $dump = implode($sep, $dump);

        return $dump;
    }


    public static function _json_dec(string $json, int $flags = JSON_THROW_ON_ERROR): array|null {
        return json_decode(json: $json, associative: true, depth: 512, flags: $flags);
    }


    public static function _json_enc(mixed $value, int $flags=JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES): string | false {
        return json_encode(value: $value, flags: $flags, depth: 512);
    }


    public static function _seconds_to_dhms(int $seconds): string
    {
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


    protected function _get_client_log_info(): string
    {
        return 'client_ip='.$this->_get_client_ip().' | client_agent='.($_SERVER['HTTP_USER_AGENT'] ?? 'none');
    }


    public static function _get_client_ip(): string|null
    {
        $ip = null;

        if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        // HTTP_X_FORWARDED_FOR usually contains more than one ip: client, proxy1, proxy2, ..., but we only want the client ip.
        if (is_string($ip) && strstr($ip, ',')) {
            $dump = explode(',', $ip);
            if (is_array($dump) && isset($dump[0])) {
                $ip = trim($dump[0]);
            }
        }

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            $ip = null;
        }

        return $ip;
    }


    public static function _hsc(string $data): string
    {
        return htmlspecialchars($data, flags: ENT_NOQUOTES | ENT_SUBSTITUTE | ENT_HTML5);
    }


    public static function _phsc(string $data): void
    {
        print(htmlspecialchars($data, flags: ENT_NOQUOTES | ENT_SUBSTITUTE | ENT_HTML5));
    }


    public static function _lazytext(string $text): string
    {
        $patterns = [
            // 1 - linefeed
            '/\n/',
            // 2 - [link_text](link_url)
            '/\[(.*?)\]\((.*?)\)/',
            // 3 - **bold text**
            '/\*\*(.*?)\*\*/i',
            // 4 - *italic text*
            '/\*(.*?)\*/i',
            // 5 - ~~struck through text~~
            '/~~(.*?)~~/i',
        ];

        $replacements = [
            // 1
            '<br>',
            // 2
            '<a href="$2">$1</a>',
            // 3
            '<strong>$1</strong>',
            // 4
            '<em>$1</em>',
            // 5
            '<s>$1</s>',
        ];

        $text = htmlspecialchars($text, flags: ENT_NOQUOTES | ENT_SUBSTITUTE | ENT_HTML5);

        $text = preg_replace($patterns, $replacements, $text);

        return $text;
    }


    public static function _get_preview_image_paths(string $type, int $id, ?string $size = null): array | string
    {
        $tn  = './file/preview/'.$type.'/'.$id.'-tn.jpg';
        $med = './file/preview/'.$type.'/'.$id.'-med.jpg';
        $big = './file/preview/'.$type.'/'.$id.'-big.jpg';

        return match($size) {
            'tn' => $tn,
            'med' => $med,
            'big' => $big,
            default => [
                'tn' => $tn,
                'med' => $med,
                'big' => $big,
            ],
        };
    }
}
