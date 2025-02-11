<?php

namespace App\Controllers;

use Framework\Database;
use Exception;

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
        (string) $name = isset($_POST['name']) ? $_POST['name'] : '';
        (string) $email = isset($_POST['email']) ? $_POST['email'] : '';
        (string) $password = isset($_POST['password']) ? $_POST['password'] : '';
        (string) $passwordConfirmation = isset($_POST['password_confirmation']) ? $_POST['password_confirmation'] : '';

        // check user form data & display error if exist
        $errors = [];

        if(!isString($name, 2, 40)){
            $errors['name'] = 'Please provide a valid name, between 2 and 40 characters';
        }
        if(!isEmail($email)){
            $errors['email'] = 'Please provide a valid email.';
        }
        if(!isString($password, 2, 40)){
            $errors['password'] = 'Please provide a valid password, between 2 and 40 characters.';
        }
        if(!isString($passwordConfirmation, 2, 40)){
            $errors['password_confirmation'] = 'Please provide a valid confirm password';
        }
        if(!empty($password) && !empty($passwordConfirmation)){
            if(!doesMatch($password, $passwordConfirmation)){
                $errors['password_confirmation'] = 'Passwords do not match';
            }            
        }

        if(!empty($errors)){
            loadView('auth/signUp',[
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

        if(isset($emailTaken) && !empty($emailTaken['email'])){
            $errors['email'] = 'Email your provided is in use.';

            loadView('auth/signUp',[
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email
                ]
            ]);
            return;
        }

        // store new user in db
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

        //redirect user 
        redirectUser('/');
    }

    public function login() {
        inspectAndDie($_POST);
    }
}
