<?php
declare(strict_types=1);
namespace s9com;


class Page extends Core
{
    protected function get_mixcloud_data(string $type, string $username): array
    {
        $cache_file = $this->conf['cache_dir'].'/mixcloud-lowtechman-'.$type.'.json';

        $dump = file_get_contents($cache_file);
        $dump = $this->_json_dec($dump);

        return $dump;
    }
}
