<?php

declare(strict_types=1);

namespace Morloax\Framework;
class Cookie
{
    private string $name;
    private mixed $data;
    private int $expireDate;
    private string $path;

    /**
     * @param string $name
     * @param mixed $data
     * @param int $expireDate
     * @param string $path
     */
    public function __construct(string $name, mixed $data, int $expireDate, string $path)
    {
        $this->name = $name;
        $this->data = $data;
        $this->expireDate = time() + $expireDate;
        $this->path = $path;

        $this->setCookie();
    }

    private function setCookie(): void
    {
        setcookie($this->name, $this->data, $this->expireDate, $this->path);
    }
}