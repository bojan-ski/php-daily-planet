<?php

declare(strict_types=1);

namespace App\Controllers;

use Exception;
use Framework\Database;
use Framework\Session;

class ReaderUserController extends Database
{
    protected Database $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function displayReaderProfilePage()
    {
        $user = Session::get('user');

        loadView('readerUser/profile', [
            'user' => $user
        ]);
    }

    public function deleteAccount()
    {
        // get reader user id
        (array) $userId = [
            'id' => Session::get('user')['id']
        ];

        if (isset($userId['id'])) {
            try {
                // delete account from db
                $this->db->dbQuery("DELETE FROM users WHERE id = :id", $userId);

                // delete user data from session from db
                Session::clearAll();

                // MESSAGE - ACCOUNT DELETED

                //redirect user 
                redirectUser("/");
            } catch (Exception $e) {
                ErrorController::randomError('User does not exist');
                return;
            }
        } else {
            ErrorController::randomError('You not able to perform the following action!');
            return;
        }
    }
}
