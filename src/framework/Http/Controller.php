<?php

namespace Morloax\Framework\Http;

use Morloax\Framework\Session;

class Controller
{
    protected static Request $request;
    protected static Session $session;

    public function __construct()
    {
        self::$request = Request::createFromGlobals();
        self::$session = new Session();
    }

    protected static function view(string $path, array $data = []): Response
    {
        $session = new Session();

        if (!file_exists(BASE_PATH . "/app/views/{$path}.php")) {
            die("The view: $path cannot be found.");
        }

        ob_start();
        require_once BASE_PATH . "/app/views/{$path}.php";
        $view = ob_get_clean();

        return new Response($view);
    }

    protected static function redirect(string $url, int $time = 0): void
    {
        header("Refresh: $time; url=$url");
    }
}