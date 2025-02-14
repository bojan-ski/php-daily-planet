<?php

namespace Framework;

class HasPermission
{
    public static function isAllowed(int $articleId): bool
    {
        if (Session::exist('user') && (Session::get('user')['role'] == 'admin' || (Session::get('user')['role'] == 'author' && Session::get('user')['id'] == $articleId))) {
            return true;
        }
        return false;
    }

    public static function approveOption(string $status): bool
    {
        if ($status == 'pending' && (Session::exist('user') && Session::get('user')['role'] == 'admin')) {
            return true;
        }
        return false;
    }

    public static function editOption(string $status, int $articleId): bool
    {
        if ($status == 'active' && (Session::exist('user') && Session::get('user')['role'] == 'admin')) {
            return true;
        } elseif ($status == 'pending' && (Session::get('user')['role'] == 'author' && Session::get('user')['id'] == $articleId)) {
            return true;
        } else {
            return false;
        }
    }
}
