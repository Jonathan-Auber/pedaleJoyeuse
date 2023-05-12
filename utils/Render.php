<?php

namespace utils;

class Render
{
    public static function render(string $path, array $var = [])
    {
        var_dump($_SESSION);
        extract($var);
        ob_start();
        require_once('views/' . $path .  '.phtml');
        $page = ob_get_clean();

        require_once('views/layout.phtml');
    }
}
