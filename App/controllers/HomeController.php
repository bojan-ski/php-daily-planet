<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Database;

class HomeController extends Database
{
    protected $db;

    public function __construct()
    {
        (array) $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function latestArticles(): void
    {
        (array) $articles = $this->db->dbQuery("SELECT * FROM articles ORDER BY created_at DESC LIMIT 3")->fetchAll();

        loadView('home', [
            'articles' => $articles
        ]);
    }
}
