<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\UsersModels;
use Framework\Session;

class ManageAppUsersController extends UsersModels
{
    private bool $adminUser;

    public function __construct()
    {
        parent::__construct();

        $this->adminUser = (Session::exist('user') && Session::get('user')['role'] == 'admin') ? true : false;
    }


    public function displayAuthorsPage(): void
    {
        $authorUsers = $this->fetchUsers('author', 'Error while retrieving all author users');

        loadView('/adminUser/authors', [
            'authorUsers' => $authorUsers
        ]);
    }

    public function removeAuthor(): void
    {
        if ($this->adminUser) {
            (array) $authorId = [
                'id' => $_POST['author_id'] ?? null
            ];

            $this->deleteAuthorFromDB($authorId);
        } else {
            ErrorController::accessDenied();
            exit;
        }
    }

    public function displayAddAuthorPage(): void
    {
        loadView('/adminUser/addAuthor');
    }

    public function addAuthor(): void
    {
        if ($this->adminUser) {
            $name = isset($_POST['name']) ? (string) $_POST['name'] : '';
            $email = isset($_POST['email']) ? (string) $_POST['email'] : '';
            $password = isset($_POST['password']) ? (string) $_POST['password'] : '';

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

            $emailTaken = $this->isEmailTaken($emailParams);

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

            $this->createUser($newAuthorUser);

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
        $readerUsers = $this->fetchUsers('reader', 'Error while retrieving all reader users');

        loadView('/adminUser/readers', [
            'readerUsers' => $readerUsers
        ]);
    }
}
