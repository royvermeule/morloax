<?php

declare(strict_types= 1);

namespace Morloax\Framework\Http;

class Response
{
    public function __construct(
        private mixed $content = "",
        private int $status = 200,
        private array $headers = [],
    ) 
    { }

    public function send(): void
    {
        echo $this->content;
    }
}