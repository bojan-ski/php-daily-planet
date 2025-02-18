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
