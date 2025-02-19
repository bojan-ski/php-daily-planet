<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Database;
use Framework\Session;
use Exception;

class ManageAppUsersController extends Database
{
    private Database $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    // FETCH USERS FROM DB - can be used in multiple class methods 
    private function fetchUsers(string $role, string $errorMessage): array | null
    {
        try {
            return $this->db->dbQuery("SELECT id, name, email, created_at FROM users WHERE `role` = '{$role}' ORDER BY created_at DESC")->fetchAll();
        } catch (Exception $e) {
            ErrorController::randomError($errorMessage);
            exit;
        }
    }

    public function displayAuthorsPage(): void
    {
        // get all author users
        (array) $authorUsers = $this->fetchUsers('author', 'Error while retrieving all author users');

        // load view
        loadView('/adminUser/authors', [
            'authorUsers' => $authorUsers
        ]);
    }

    public function removeAuthor(): void
    {
        if (Session::exist('user') && Session::get('user')['role'] == 'admin') {
            // get author user id
            (array) $authorId = [
                'id' => $_POST['author_id'] ?? null
            ];

            if (isset($authorId['id'])) {
                try {
                    // delete author user from db
                    $this->db->dbQuery("DELETE FROM users WHERE id = :id", $authorId);

                    // store pop up msg in session
                    Session::set('pop_up', [
                        'message' => 'Author removed'
                    ]);

                    //redirect user 
                    redirectUser("/authors");
                } catch (Exception $e) {
                    ErrorController::randomError('Author does not exist');
                    exit;
                }
            } else {
                ErrorController::randomError();
                exit;
            }
        } else {
            ErrorController::accessDenied();
            exit;
        }
    }

    public function displayAddAuthorPage(): void
    {
        // load view
        loadView('/adminUser/addAuthor');
    }

    public function addAuthor(): void
    {
        if (Session::exist('user') && Session::get('user')['role'] == 'admin') {
            (string) $name = isset($_POST['name']) ? $_POST['name'] : '';
            (string) $email = isset($_POST['email']) ? $_POST['email'] : '';
            (string) $password = isset($_POST['password']) ? $_POST['password'] : '';

            // check form data & display error if exist
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

            if (!empty($errors)) {
                loadView('/adminUser/addAuthor', [
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

            try {
                (array) $emailTaken = $this->db->dbQuery("SELECT DISTINCT `email` FROM users WHERE email = :email", $emailParams)->fetch();
            } catch (Exception $e) {
                ErrorController::randomError('Error while creating account');
                exit;
            }

            if (isset($emailTaken) && !empty($emailTaken['email'])) {
                $errors['email'] = 'Email your provided is in use.';

                loadView('/adminUser/addAuthor', [
                    'errors' => $errors,
                    'user' => [
                        'name' => $name,
                        'email' => $email
                    ]
                ]);
                exit;
            }

            // if all is good -> store new author user in db
            (array) $newAuthorUser = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'created_at' => date("Y-m-d h:i:s"),
                'role' => 'author'
            ];

            try {
                $this->db->dbQuery("INSERT INTO users (`name`, `email`, `password`, `created_at`, `role`) VALUES (:name, :email, :password, :created_at, :role)", $newAuthorUser);
            } catch (Exception $e) {
                ErrorController::randomError('Error while creating account');
                exit;
            }

            // store pop up msg in session
            Session::set('pop_up', [
                'message' => 'Author created'
            ]);

            //redirect user 
            redirectUser('/authors');
        } else {
            ErrorController::accessDenied();
            exit;
        }
    }

    public function displayReadersPage(): void
    {
        // get all reader users
        (array) $readerUsers = $this->fetchUsers('reader', 'Error while retrieving all reader users');

        // load view
        loadView('/adminUser/readers', [
            'readerUsers' => $readerUsers
        ]);
    }
}
