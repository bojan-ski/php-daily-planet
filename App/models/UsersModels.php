<?php

declare(strict_types=1);

namespace App\Models;

use App\Controllers\ErrorController;
use Framework\Database;
use Framework\Session;
use Exception;

class UsersModels extends Database
{
    // CHECK DB IF EMAIL IS TAKEN
    protected function isEmailTaken(array $emailParams): bool
    {
        try {
            return (bool) $this->dbQuery("SELECT DISTINCT `email` FROM users WHERE email = :email", $emailParams)->fetch();
        } catch (Exception $e) {
            ErrorController::randomError('Error while creating account');
            exit;
        }
    }

    // CREATE/ADD NEW USER
    protected function createUser(array $newUserData): void
    {
        try {
            $this->dbQuery("INSERT INTO users (`name`, `email`, `password`, `created_at`, `role`) VALUES (:name, :email, :password, :created_at, :role)", $newUserData);
        } catch (Exception $e) {
            ErrorController::randomError('Error while creating account');
            exit;
        }
    }

    // RETURN NEW USER ID FROM DB
    protected function newUserID(): string
    {
        try {
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            ErrorController::randomError('Error while creating account');
            exit;
        }
    }

    // CHECK DB IF USER EXISTS
    protected function userExists(array $emailParams): array
    {
        try {
            return $this->dbQuery("SELECT * FROM users WHERE email = :email", $emailParams)->fetch();
        } catch (Exception $e) {
            ErrorController::randomError('Error while login');
            exit;
        }
    }

    // FETCH USERS FROM DB - admin user 
    protected function fetchUsers(string $role, string $errorMessage): array
    {
        try {
            return $this->dbQuery("SELECT id, name, email, created_at FROM users WHERE `role` = '{$role}' ORDER BY created_at DESC")->fetchAll();
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
                $this->dbQuery("DELETE FROM users WHERE id = :id", $authorId);

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

    // DELETE READER USER/ACCOUNT FROM DB - reader user
    public function deleteReaderUserAccount(array $userId): void
    {
        try {
            // delete account from db
            $this->dbQuery("DELETE FROM users WHERE id = :id", $userId);

            // delete user data from session
            Session::clearAll();

            //redirect user 
            redirectUser("/");
        } catch (Exception $e) {
            ErrorController::randomError('User does not exist');
            exit;
        }
    }
}
