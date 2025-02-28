<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Database;
use Framework\Session;
use App\Controllers\ErrorController;
use Exception;

class ArticlesModels extends Database
{
    // FETCH ARTICLES FROM DB
    protected function fetchArticles(string $updatedQuery, array $params = []): array
    {
        try {
            return $this->dbQuery("SELECT * FROM articles WHERE {$updatedQuery}", $params)->fetchAll();
        } catch (Exception $e) {
            ErrorController::randomError('Error while retrieving articles');
            exit;
        }
    }

    // FETCH SELECTED ARTICLE FROM DB
    protected function fetchSelectedArticle(array $params): array
    {
        // get selected article - params
        (array) $articleId = [
            'id' => $params['id'] ?? ''
        ];

        try {
            $selectedArticle = $this->dbQuery("SELECT * FROM articles WHERE id = :id", $articleId)->fetch();

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
            $selectedArticleAuthor = $this->dbQuery("SELECT DISTINCT `name` FROM users WHERE id = :user_id", $authorParams)->fetch();
        } catch (Exception $e) {
            $selectedArticleAuthor = '';
        }

        return $selectedArticleAuthor;
    }

    // CREATE NEW ARTICLE IN DB - author user
    protected function createArticle(array $newArticleData): void
    {
        try {
            $query = "INSERT INTO articles (`title`, `description`, `section_one`, `section_two`,
            `section_three`, `created_at`, `user_id`, `status`) VALUES (:title, :description, :section_one, :section_two, :section_three, :created_at, :user_id, :status )";

            $this->dbQuery($query, $newArticleData);
        } catch (Exception $e) {
            ErrorController::randomError('Error while submitting article');
            exit;
        }
    }

    // APPROVE ARTICLE - UPDATE ARTICLE IN DB - admin user
    protected function approveArticle(array $articleParams): void
    {
        try {
            $this->dbQuery("UPDATE articles SET `status` = 'active' WHERE id = :id", $articleParams);

            // store pop up msg in session
            Session::set('pop_up', [
                'message' => 'Article approved'
            ]);

            //redirect user 
            redirectUser('/pending_articles');
        } catch (Exception $e) {
            ErrorController::randomError();
            exit;
        }
    }

    // UPDATE ARTICLE IN DB - author & admin user
    protected function editArticle(string $updateArticleQuery, array $updatedSelectedArticle): void
    {
        try {
            $this->dbQuery($updateArticleQuery, $updatedSelectedArticle);
        } catch (Exception $e) {
            ErrorController::randomError('Error while editing article');
            exit;
        }
    }

    // DELETE ARTICLE FROM DB - author & admin user
    protected function deleteArticle(array $articleParams, string $backPath): void
    {
        try {
            $this->dbQuery("DELETE FROM articles WHERE id = :id", $articleParams);

            // store pop up msg in session
            Session::set('pop_up', [
                'message' => 'Article deleted'
            ]);

            //redirect user 
            redirectUser("/$backPath");
        } catch (Exception $e) {
            ErrorController::randomError();
            exit;
        }
    }

    // CHECK IF ARTICLE BOOKMARKED - reader user
    protected function isArticleBookmarked(array $bookmarkParams): bool | array
    {
        try {
            return $this->dbQuery("SELECT * FROM bookmarked WHERE user_id = :user_id AND article_id = :article_id", $bookmarkParams)->fetch();
        } catch (Exception $e) {
            ErrorController::randomError();
            exit;
        }
    }

    // FETCH BOOKMARKED ARTICLE - reader user
    protected function fetchBookmarkedArticles(array $user): array | null
    {
        (array) $userId = [
            'id' => $user['id'] ?? null
        ];

        try {
            return $this->dbQuery("SELECT * FROM bookmarked WHERE user_id = :id", $userId)->fetchAll();
        } catch (Exception $e) {
            ErrorController::randomError('There was an error while displaying user bookmarked articles');
            exit;
        }
    }

    // BOOKMARK ARTICLE - SAVE ARTICLE IN bookmarked TABLE - reader user
    protected function addBookmark(array $bookmarkParams, string $backPath, string $articleId)
    {
        try {
            $this->dbQuery("DELETE FROM bookmarked WHERE user_id = :user_id AND article_id = :article_id", $bookmarkParams);

            // store pop up msg in session
            Session::set('pop_up', [
                'message' => 'Bookmark removed'
            ]);

            //redirect user 
            redirectUser("/$backPath/" . $articleId);
        } catch (Exception $e) {
            ErrorController::randomError('There was an error while removing the bookmark');
            exit;
        }
    }

    // REMOVE BOOKMARK ARTICLE - DELETE ARTICLE FROM bookmarked TABLE - reader user
    protected function removeBookmark(array $newBookmark, string $backPath, string $articleId)
    {
        try {
            $this->dbQuery("INSERT INTO bookmarked (`user_id`, `article_id`, `created_at`) VALUES (:user_id, :article_id, :created_at)", $newBookmark);

            // store pop up msg in session
            Session::set('pop_up', [
                'message' => 'Article bookmarked'
            ]);

            //redirect user 
            redirectUser("/$backPath/" . $articleId);
        } catch (Exception $e) {
            ErrorController::randomError('There was an error while bookmarking the article');
            exit;
        }
    }
}
