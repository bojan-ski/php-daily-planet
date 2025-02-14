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
}
