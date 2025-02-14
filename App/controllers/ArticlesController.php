<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Database;
use Exception;

class ArticlesController extends Database
{
    protected Database $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    protected function fetchArticles(string $updatedQuery, string $pageTitle, array $params = [])
    {
        try {
            (array) $articles = $this->db->dbQuery("SELECT * FROM articles WHERE {$updatedQuery} ORDER BY created_at DESC", $params)->fetchAll();

            loadView('articles', [
                'articles' => $articles,
                'pageTitle' => $pageTitle
            ]);
        } catch (Exception $e) {
            ErrorController::randomError('Error while retrieving articles');
        }
    }

    // DISPLAY ALL ACTIVE ARTICLES - articles page
    public function displayArticlesPage(): void
    {
        $this->fetchArticles("`status` = 'active'", 'All News');
    }

    // DISPLAY SELECTED ARTICLE - selected article page
    public function displaySelectedArticlePage(array $params): void
    {
        // get selected article
        (string) $id = $params['id'] ?? '';
        (array) $params = [
            'id' => $id
        ];

        try {
            (array) $selectedArticle = $this->db->dbQuery("SELECT * FROM articles WHERE id = :id", $params)->fetch();
        } catch (Exception $e) {
            ErrorController::randomError();
            return;
        }

        // display not found if selected article does not exist
        if (!$selectedArticle) {
            ErrorController::notFound();
            return;
        };

        /// get selected article - author
        (array) $authorParams = [
            'user_id' => $selectedArticle['user_id']
        ];

        try {
            (array) $selectedArticleAuthor = $this->db->dbQuery("SELECT DISTINCT `name` FROM users WHERE id = :user_id", $authorParams)->fetch();
        } catch (Exception $e) {
            $selectedArticleAuthor = '';
        }

        // display page - view
        loadView('selectedArticle', [
            'selectedArticle' => $selectedArticle,
            'selectedArticleAuthor' => $selectedArticleAuthor
        ]);
    }
}
