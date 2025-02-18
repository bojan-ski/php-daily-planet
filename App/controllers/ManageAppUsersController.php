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
            'authorUsers' => $authorUsers ?? ''
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

                    // MESSAGE - AUTHOR REMOVED

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
            ErrorController::randomError('You not able to perform the following action!');
            exit;
        }
    }

    public function displayReadersPage(): void
    {
        // get all reader users
        (array) $readerUsers = $this->fetchUsers('reader', 'Error while retrieving all reader users');

        // load view
        loadView('/adminUser/readers', [
            'readerUsers' => $readerUsers ?? ''
        ]);
    }
}
