<?php

declare(strict_types=1);

namespace Framework;

class Session
{
    public static function start(): void
    {
        if (session_status() == PHP_SESSION_NONE) session_start();
    }

    public static function exist(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function set(string $key, array $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key): array | null
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function clear(string $key): void
    {
        if (isset($_SESSION[$key])) unset($_SESSION[$key]);
    }

    public static function clearAll(): void
    {
        session_unset();
        session_destroy();
    }
}
