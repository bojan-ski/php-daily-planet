<?php

declare(strict_types=1);

namespace Framework\Middleware;

use App\Controllers\ErrorController;
use Framework\Session;

class Authorization
{
    private function isLoggedIn(): bool
    {
        return Session::exist('user');
    }

    private function getUserRole(): string
    {
        if ($this->isLoggedIn()) {
            return Session::get('user')['role'];
        }
        return 'guest';
    }

    protected function isAuthorized(array $roles)
    {
        $userRole = $this->getUserRole();

        if (!in_array($userRole, $roles)) {
            ErrorController::accessDenied();
            exit;
        }
    }
}
