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

    // DISPLAY ALL ARTICLEs - articles page
    public function articlesList(): void
    {
        (array) $articles = $this->db->dbQuery("SELECT * FROM articles ORDER BY created_at DESC")->fetchAll();

        loadView('articles', [
            'articles' => $articles
        ]);
    }

    // DISPLAY SELECTED ARTICLE - selected article page
    public function displayArticle(array $params): void
    {
        // inspect($params);

        // get selected article
        (string) $id = $params['id'] ?? '';
        (array) $params = [
            'id' => $id
        ];

        (array) $selectedArticle = $this->db->dbQuery("SELECT * FROM articles WHERE id = :id", $params)->fetch();

        // display error if selected article does not exist
        if (!$selectedArticle) {
            echo 'Selected article does not exist';
            exit();
        };

        /// get selected article - author
        (array) $authorParams = [
            'user_id' => $selectedArticle['user_id']
        ];

        (array) $selectedArticleAuthor = $this->db->dbQuery("SELECT DISTINCT `name` FROM users WHERE id = :user_id", $authorParams)->fetch();

        // display page - view
        loadView('selectedArticle', [
            'selectedArticle' => $selectedArticle,
            'selectedArticleAuthor' => $selectedArticleAuthor
        ]);
    }
}
