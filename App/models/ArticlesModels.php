<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Database;
use App\Controllers\ErrorController;
use Exception;

class ArticlesModels extends Database
{
    private Database $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    // FETCH ARTICLES FROM DB - can be used in multiple class methods
    protected function fetchArticles(string $updatedQuery, array $params = []): array
    {
        try {
            return $this->db->dbQuery("SELECT * FROM articles WHERE {$updatedQuery}", $params)->fetchAll();
        } catch (Exception $e) {
            ErrorController::randomError('Error while retrieving articles');
            exit;
        }
    }

    // FETCH SELECTED ARTICLE FROM DB - can be used in multiple class methods
    protected function fetchSelectedArticle(array $params): array
    {
        // get selected article - params
        (array) $articleId = [
            'id' => $params['id'] ?? ''
        ];

        try {
            $selectedArticle = $this->db->dbQuery("SELECT * FROM articles WHERE id = :id", $articleId)->fetch();

            // display not found if selected article does not exist
            if (!$selectedArticle) {
                ErrorController::notFound();
                exit;
            };

            // if exist - return selected article
            return $selectedArticle;
        } catch (Exception $e) {
            ErrorController::randomError();
            exit;
        }
    }

    // FETCH SELECTED ARTICLE AUTHOR FROM DB
    protected function fetchSelectedArticleAuthor(array $authorParams): array | string
    {
        try {
            $selectedArticleAuthor = $this->db->dbQuery("SELECT DISTINCT `name` FROM users WHERE id = :user_id", $authorParams)->fetch();
        } catch (Exception $e) {
            $selectedArticleAuthor = '';
        }

        return $selectedArticleAuthor;
    }

    // FETCH BOOKMARKED ARTICLE FROM DB 
    protected function fetchBookmarkedArticles(array $bookmarkParams): array
    {
        try {
            return $this->db->dbQuery("SELECT * FROM bookmarked WHERE user_id = :user_id AND article_id = :article_id", $bookmarkParams)->fetch();
        } catch (Exception $e) {
            ErrorController::randomError();
            exit;
        }
    }
}
