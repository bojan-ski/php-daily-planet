<?php

declare(strict_types=1);

namespace Framework;

class FlashMsg
{
    public static function displayPopUp(string $key): string | null
    {
        $message = Session::get($key);
        $message = $message['message'] ?? null;

        Session::clear($key);

        return $message;
    }
}
