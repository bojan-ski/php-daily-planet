<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Database;
use Framework\Session;
use Exception;

class ArticlesController extends Database
{
    protected Database $db;
    private string $limit;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);

        $this->limit = (string) $_ENV['LIMIT'];
    }

    // FETCH ARTICLES FROM DB - can be used in multiple class methods
    protected function fetchArticles(string $updatedQuery, string $pageTitle, array $params = []): void
    {
        try {
            $articles = $this->db->dbQuery("SELECT * FROM articles WHERE {$updatedQuery}", $params)->fetchAll();

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

    // DISPLAY ALL ACTIVE ARTICLES PAGE
    public function displayArticlesPage(): void
    {       
        $this->fetchArticles("`status` = 'active' ORDER BY created_at DESC LIMIT {$this->limit}", 'All News');
    }

    // SEARCH FEATURE FOR THE ALL ACTIVE ARTICLES PAGE
    public function searchArticle()
    {
        $title = isset($_POST['article_title']) ? (string) $_POST['article_title'] : '';

        // check form data and display error
        if (!isString($title, 2, 40)) {
            // store pop up msg in session
            Session::set('pop_up', [
                'message' => 'Please provide a valid article title'
            ]);

            //redirect user 
            redirectUser("/articles");
        }

        // if all is good
        try {
            $query = "SELECT * FROM articles WHERE title LIKE :title";
            $params = [
                'title' => "%{$title}%",
            ];

            $articles = $this->db->dbQuery($query, $params)->fetchAll();
        } catch (Exception $e) {
            ErrorController::randomError('Error while retrieving articles');
            exit;
        }

        // load view
        if (empty($articles)) {
            // store pop up msg in session
            Session::set('pop_up', [
                'message' => 'There are articles based on search term'
            ]);

            //redirect user 
            redirectUser("/articles");
        } else {
            loadView('articles', [
                'articles' => $articles,
                'pageTitle' => 'All News',
                'search' => $title
            ]);
        }
    }

    // PAGINATION FEATURE FOR THE ALL ACTIVE ARTICLES PAGE
    public function loadMoreArticles(): void
    {
        $offset = isset($_POST['offset']) ? (int) $_POST['offset'] : 0;

        try {
            $articles = $this->db->dbQuery("SELECT * FROM articles WHERE `status` = 'active' ORDER BY created_at DESC LIMIT {$this->limit} OFFSET {$offset}")->fetchAll();

            foreach ($articles as $article) {
                loadPartial('articleCard', ['article' => $article]);
            }
        } catch (Exception $e) {
            ErrorController::randomError('Error while retrieving articles');
            exit;
        }
    }

    // DISPLAY SELECTED ARTICLE PAGE
    public function displaySelectedArticlePage(array $params): void
    {
        $selectedArticle = $this->fetchSelectedArticle($params);

        /// get selected article - author
        $authorParams = [
            'user_id' => $selectedArticle['user_id']
        ];

        try {
            $selectedArticleAuthor = $this->db->dbQuery("SELECT DISTINCT `name` FROM users WHERE id = :user_id", $authorParams)->fetch();
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
