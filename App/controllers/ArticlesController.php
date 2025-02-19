<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Database;
use Framework\Session;
use Exception;

class ArticlesController extends Database
{
    protected Database $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    // FETCH ARTICLES FROM DB - can be used in multiple class methods
    protected function fetchArticles(string $updatedQuery, string $pageTitle, array $params = []): void
    {
        try {
            (array) $articles = $this->db->dbQuery("SELECT * FROM articles WHERE {$updatedQuery} ORDER BY created_at DESC", $params)->fetchAll();

            loadView('articles', [
                'articles' => $articles,
                'pageTitle' => $pageTitle
            ]);
        } catch (Exception $e) {
            ErrorController::randomError('Error while retrieving articles');
            exit;
        }
    }

    // FETCH SELECTED ARTICLE FROM DB - can be used in multiple class methods
    protected function fetchSelectedArticle(array $params): array
    {
        // get selected article
        (string) $id = $params['id'] ?? '';
        (array) $articleId = [
            'id' => $id
        ];

        try {
            return $this->db->dbQuery("SELECT * FROM articles WHERE id = :id", $articleId)->fetch();
        } catch (Exception $e) {
            ErrorController::randomError();
            exit;
        }

        // display not found if selected article does not exist
        if (!$selectedArticle) {
            ErrorController::notFound();
            exit;
        };
    }

    public function displayArticlesPage(): void
    {
        $this->fetchArticles("`status` = 'active'", 'All News');
    }

    public function displaySelectedArticlePage(array $params): void
    {
        (array) $selectedArticle = $this->fetchSelectedArticle($params);

        /// get selected article - author
        (array) $authorParams = [
            'user_id' => $selectedArticle['user_id']
        ];

        try {
            (array) $selectedArticleAuthor = $this->db->dbQuery("SELECT DISTINCT `name` FROM users WHERE id = :user_id", $authorParams)->fetch();
        } catch (Exception $e) {
            $selectedArticleAuthor = '';
        }

        if (Session::exist('user') && Session::get('user')['role'] == 'reader') {
            // check if article is bookmarked - READER USER ONLY
            (bool) $articleBookmarked = false;
            (string) $userId = Session::get('user')['id'] ?? '';
            (string) $articleId = $params['id'] ?? '';

            (array) $bookmarkParams = [
                'user_id' => $userId,
                'article_id' => $articleId
            ];

            try {
                (array) $bookmarkedArticle = $this->db->dbQuery("SELECT * FROM bookmarked WHERE user_id = :user_id AND article_id = :article_id", $bookmarkParams)->fetch();
            } catch (Exception $e) {
                ErrorController::randomError();
                exit;
            }

            // if bookmarked
            if ($bookmarkedArticle) {
                $articleBookmarked = true;
            }

            // display page - view
            loadView('selectedArticle', [
                'selectedArticle' => $selectedArticle,
                'selectedArticleAuthor' => $selectedArticleAuthor,
                'articleBookmarked' => $articleBookmarked
            ]);
        } else {
            // display page - view
            loadView('selectedArticle', [
                'selectedArticle' => $selectedArticle,
                'selectedArticleAuthor' => $selectedArticleAuthor
            ]);
        }
    }
}
