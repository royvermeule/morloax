<?php

namespace Morloax\Framework\Middleware;

use Morloax\Framework\Http\Response;
use Morloax\Framework\Middleware\Middleware;

class Session implements Middleware
{

    public function __invoke(): ?Response
    {
        $session = new \Morloax\Framework\Session();
        $session->regenerate();

        return null;
    }
}