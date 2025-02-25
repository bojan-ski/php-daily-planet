<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\UsersModels;
use Framework\Database;
use Framework\Session;
use Exception;

class AuthController extends UsersModels
{
    public function __construct()
    {
        parent::__construct();
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
        $name = isset($_POST['name']) ? (string) $_POST['name'] : '';
        $email = isset($_POST['email']) ? (string) $_POST['email'] : '';
        $password = isset($_POST['password']) ? (string) $_POST['password'] : '';
        $passwordConfirmation = isset($_POST['password_confirmation']) ? (string) $_POST['password_confirmation'] : '';

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
            exit;
        }

        // check if email is taken
        (array) $emailParams = [
            'email' => $email
        ];

        $emailTaken = $this->isEmailTaken($emailParams);

        if (isset($emailTaken) && !empty($emailTaken['email'])) {
            $errors['email'] = 'Email your provided is in use.';

            loadView('auth/signUp', [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email
                ]
            ]);
            exit;
        }

        // if all is good -> store new user in db
        (array) $newUser = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'created_at' => date("Y-m-d h:i:s"),
            'role' => 'reader'
        ];

        $this->createUser($newUser);

        // get id of new user
        $newUserId = $this->newUserID();

        // store new user in session
        Session::set('user', [
            'id' => $newUserId,
            'name' => $name,
            'email' => $email,
            'role' => 'reader'
        ]);

        // store pop up msg in session
        Session::set('pop_up', [
            'message' => 'Account created'
        ]);

        //redirect user 
        redirectUser('/');
    }

    public function login(): void
    {
        $email = isset($_POST['email']) ? (string) $_POST['email'] : '';
        $password = isset($_POST['password']) ? (string) $_POST['password'] : '';

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
            exit;
        }

        // check email
        (array) $emailParams = [
            'email' => $email
        ];

        $user = $this->userExists($emailParams);

        if (!isset($user) || empty($user['email'])) {
            $errors['bad_credentials'] = 'Incorrect Credentials';

            loadView('auth/signIn', [
                'errors' => $errors,
            ]);

            exit;
        }

        // check password
        if (!password_verify($password, $user['password'])) {
            $errors['bad_credentials'] = 'Incorrect Credentials';

            loadView('auth/signIn', [
                'errors' => $errors
            ]);

            exit;
        }

        // store user in session
        Session::set('user', [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ]);

        // store pop up msg in session
        Session::set('pop_up', [
            'message' => 'You have logged in'
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
