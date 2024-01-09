<?php

declare(strict_types=1);

namespace Morloax\Framework\Middleware;

use Morloax\Framework\Http\Response;

interface Middleware
{
    public function __invoke(): ?Response;
}
