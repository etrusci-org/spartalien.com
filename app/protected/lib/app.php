<?php
declare(strict_types=1);


class App extends WebApp {
    public function parseLazyText(string $input): string|null {
        $patterns = array(
            '/\n/i',  // newline
            '/routeURL\(([a-z0-9.:\/]+)\)/i', // routeURL(route_request)
            '/\[([a-z0-9.:\/\' ]+)\]\(([a-z0-9.:\/\(\)]+)\)/i', // [link_text](link_url)
        );

        $replacements = array(
            '<br>',
            $this->routeURL('$1'),
            '<a href="$2" rel="nofollow">$1</a>',
        );

        return preg_replace($patterns, $replacements, $input);
    }
}
