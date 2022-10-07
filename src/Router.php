<?php

/** davidggdev - main index controller */

namespace Balrog;

class Router
{
    /**
     * Parse array to json and enable exceptions on error
     */
    public function getRoute(): array
    {
        return [
            'request_uri' => (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] !== '/') ? $_SERVER['REQUEST_URI'] : '/',
            'query_string' => (isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : '',
        ];
    }
}
