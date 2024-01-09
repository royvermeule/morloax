<?php

declare(strict_types=1);

namespace Morloax\Framework;

use App\Model\Sessionlog;
use Morloax\Framework\Http\Request;
use Random\RandomException;

class Session
{
    public function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        session_start();

        if (!$this->has('csrf_token')) {
            try {
                $this->set('csrf_token', bin2hex(random_bytes(32)));
            } catch (RandomException $e) {
                die($e);
            }
        }

        if (!$this->has('timestamp')) {
            $this->set('timestamp', time());
        }

        $request = Request::createFromGlobals();
        $ipAddr = $request->getIp();
        $this->set('ip_address', $ipAddr);
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function clear(): void
    {
        $_SESSION = [];
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function regenerate(): void
    {
        if ($this->get('timestamp') - time() > 3600) {
            session_regenerate_id();
            try {
                $this->set('csrf_token', bin2hex(random_bytes(32)));
            } catch (RandomException $e) {
                die($e);
            }
            $this->set('timestamp', time());
        }
    }
}

