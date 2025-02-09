<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Database;

class ArticlesController extends Database
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function articlesList(): void
    {
        (array) $articles = $this->db->dbQuery("SELECT * FROM articles ORDER BY created_at DESC")->fetchAll();

        loadView('articles', [
            'articles' => $articles
        ]);
    }
}
