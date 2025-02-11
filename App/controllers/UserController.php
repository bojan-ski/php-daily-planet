<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Database;
use Exception;
use Framework\Session;

class UserController extends Database
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function displaySignUpPage(): void
    {
        loadView('auth/signUp');
    }

    public function displaySignInPage(): void
    {
        loadView('auth/signIn');
    }

    public function register(): void
    {
        (string) $name = isset($_POST['name']) ? $_POST['name'] : '';
        (string) $email = isset($_POST['email']) ? $_POST['email'] : '';
        (string) $password = isset($_POST['password']) ? $_POST['password'] : '';
        (string) $passwordConfirmation = isset($_POST['password_confirmation']) ? $_POST['password_confirmation'] : '';

        // check user form data & display error if exist
        $errors = [];

        if (!isString($name, 2, 40)) {
            $errors['name'] = 'Please provide a valid name, between 2 and 40 characters';
        }
        if (!isEmail($email)) {
            $errors['email'] = 'Please provide a valid email.';
        }
        if (!isString($password, 2, 40)) {
            $errors['password'] = 'Please provide a valid password, between 2 and 40 characters.';
        }
        if (!isString($passwordConfirmation, 2, 40)) {
            $errors['password_confirmation'] = 'Please provide a valid confirm password';
        }
        if (!empty($password) && !empty($passwordConfirmation)) {
            if (!doesMatch($password, $passwordConfirmation)) {
                $errors['password_confirmation'] = 'Passwords do not match';
            }
        }

        if (!empty($errors)) {
            loadView('auth/signUp', [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email
                ]
            ]);
            return;
        }

        // check if email is taken
        (array) $emailParams = [
            'email' => $email
        ];

        try {
            (array) $emailTaken = $this->db->dbQuery("SELECT DISTINCT `email` FROM users WHERE email = :email", $emailParams)->fetch();
        } catch (Exception $e) {
            ErrorController::randomError('Error while creating account');
            return;
        }

        if (isset($emailTaken) && !empty($emailTaken['email'])) {
            $errors['email'] = 'Email your provided is in use.';

            loadView('auth/signUp', [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email
                ]
            ]);
            return;
        }

        // if all is good -> store new user in db
        (array) $newUser = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'created_at' => date("Y-m-d h:i:s"),
            'role' => 'reader'
        ];

        try {
            $this->db->dbQuery("INSERT INTO users (`name`, `email`, `password`, `created_at`, `role`) VALUES (:name, :email, :password, :created_at, :role)", $newUser);
        } catch (Exception $e) {
            ErrorController::randomError('Error while creating account');
            return;
        }

        // get id of new user
        $newUserId = $this->db->conn->lastInsertId();

        // store new user in session
        Session::set('user', [
            'id' => $newUserId,
            'name' => $name,
            'email' => $email,
            'role' => 'reader'
        ]);

        //redirect user 
        redirectUser('/');
    }

    public function login(): void
    {
        (string) $email = isset($_POST['email']) ? $_POST['email'] : '';
        (string) $password = isset($_POST['password']) ? $_POST['password'] : '';

        // check user form data & display error if exist
        $errors = [];

        if (!isEmail($email)) {
            $errors['email'] = 'Please provide a valid email.';
        }
        if (!isString($password, 2, 40)) {
            $errors['password'] = 'Please provide a valid password, between 2 and 40 characters.';
        }

        if (!empty($errors)) {
            loadView('auth/signIn', [
                'errors' => $errors,
                'user' => [
                    'email' => $email
                ]
            ]);
            return;
        }

        // check email
        (array) $emailParams = [
            'email' => $email
        ];

        try {
            (array) $user = $this->db->dbQuery("SELECT * FROM users WHERE email = :email", $emailParams)->fetch();
        } catch (Exception $e) {
            ErrorController::randomError('Error while login');
            return;
        }

        if (!isset($user) || empty($user['email'])) {
            $errors['bad_credentials'] = 'Incorrect Credentials';

            loadView('auth/signIn', [
                'errors' => $errors,
            ]);

            return;
        }

        // check password
        if (!password_verify($password, $user['password'])) {
            $errors['bad_credentials'] = 'Incorrect Credentials';

            loadView('auth/signIn', [
                'errors' => $errors
            ]);

            return;
        }

        // store user in session
        Session::set('user', [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ]);

        //redirect user 
        redirectUser('/');
    }

    public function logout(): void {
        Session::clearAll();

        //redirect user 
        redirectUser('/');
    }
}
