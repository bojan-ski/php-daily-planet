<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Database;
use App\Controllers\ErrorController;
use Exception;
use Framework\Session;

class UsersModels extends Database
{
    private Database $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    // CHECK DB IF EMAIL IS TAKEN
    protected function isEmailTaken(array $emailParams): bool
    {
        try {
            return $this->db->dbQuery("SELECT DISTINCT `email` FROM users WHERE email = :email", $emailParams)->fetch();
        } catch (Exception $e) {
            ErrorController::randomError('Error while creating account');
            exit;
        }
    }

    // CREATE NEW USER IN DB
    protected function createUser(array $newUserData): void
    {
        try {
            $this->db->dbQuery("INSERT INTO users (`name`, `email`, `password`, `created_at`, `role`) VALUES (:name, :email, :password, :created_at, :role)", $newUserData);
        } catch (Exception $e) {
            ErrorController::randomError('Error while creating account');
            exit;
        }
    }

    // RETURN NEW USER ID FROM DB
    protected function newUserID(): ?string 
    {
        try {
            return $this->db->conn->lastInsertId();
        } catch (Exception $e) {
            ErrorController::randomError('Error while creating account');
            exit;
        }
    }

    // CHECK DB IF USER EXISTS
    protected function userExists(array $emailParams): array 
    {
        try {
            return $this->db->dbQuery("SELECT * FROM users WHERE email = :email", $emailParams)->fetch();
        } catch (Exception $e) {
            ErrorController::randomError('Error while login');
            exit;
        }
    }

    // FETCH USERS FROM DB - admin user 
    protected function fetchUsers(string $role, string $errorMessage): array
    {
        try {
            return $this->db->dbQuery("SELECT id, name, email, created_at FROM users WHERE `role` = '{$role}' ORDER BY created_at DESC")->fetchAll();
        } catch (Exception $e) {
            ErrorController::randomError($errorMessage);
            exit;
        }
    }

    // DELETE AUTHOR USER FROM DB - admin user
    protected function deleteAuthorFromDB(array $authorId): void
    {
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
    }
}
