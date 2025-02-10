<?php

namespace App\Controllers;

use Framework\Database;

class UserController extends Database
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function displaySignUpPage() {
        loadView('auth/signUp');
    }

    public function displaySignInPage() {
        loadView('auth/signIn');
    }

    public function register() {
        inspectAndDie($_POST);
    }

    public function login() {
        inspectAndDie($_POST);
    }
}
