<?php

declare(strict_types=1);

namespace App\Controllers;

use Exception;
use Framework\Database;

class HomeController extends Database
{
    protected Database $db;

    public function __construct()
    {
        (array) $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function latestArticles(): void
    {
        try {
            (array) $articles = $this->db->dbQuery("SELECT * FROM articles WHERE `status` = 'active' ORDER BY created_at DESC LIMIT 3")->fetchAll();

            loadView('home', [
                'articles' => $articles
            ]);
        } catch (Exception $e) {
            ErrorController::randomError('Error while retrieving latest articles');
        }
    }
}
