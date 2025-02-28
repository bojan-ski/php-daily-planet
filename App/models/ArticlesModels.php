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

    // FETCH LATEST 3 ARTICLES FROM DB - home page
    protected function fetchArticlesForHomePage(): array
    {
        $updatedQuery = "`status` = 'active' ORDER BY created_at DESC LIMIT 3";

        return $this->fetchArticles($updatedQuery);
    }

    // FETCH ACTIVE ARTICLES FROM DB - articles page
    protected function fetchArticlesForArticlesPage(int $limit): array
    {
        $updatedQuery = "`status` = 'active' ORDER BY created_at DESC LIMIT {$limit}";

        return $this->fetchArticles($updatedQuery);
    }

    // FETCH/SEARCH FOR SPECIFIC ARTICLE/ARTICLES - search result - articles page
    protected function searchResults(string $title): array
    {
        $updatedQuery = "title LIKE :title";
        $params = [
            'title' => "%{$title}%",
        ];

        return $this->fetchArticles($updatedQuery, $params);
    }

    // FETCH MORE ACTIVE ARTICLES FROM DB - pagination - articles page
    protected function pagination(int $limit, int $offset): array
    {
        $updatedQuery = "`status` = 'active' ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}";

        return $this->fetchArticles($updatedQuery);
    }

    // FETCH ALL AUTHORS ACTIVE ARTICLES FROM DB - my active article page - author user
    protected function fetchAuthorActiveArticles(array $userId): array
    {
        $updatedQuery = "`status` = 'active' AND `user_id` = :id ORDER BY created_at DESC";

        return $this->fetchArticles($updatedQuery, $userId);
    }

    // FETCH ALL AUTHORS PENDING ARTICLES FROM DB - my pending article page - author user
    protected function fetchAuthorPendingArticles(array $userId): array
    {
        $updatedQuery = "`status` = 'pending' AND `user_id` = :id ORDER BY created_at DESC";

        return $this->fetchArticles($updatedQuery, $userId);
    }

    // CREATE NEW ARTICLE IN DB - author user
    protected function createNewArticle(array $newArticleData): void
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

    // UPDATE ARTICLE IN DB - author & admin user
    protected function editArticle(array $updatedSelectedArticle): void
    {
        try {
            $updateArticleQuery = "UPDATE articles 
            SET title = :title, 
                description = :description, 
                section_one = :section_one, 
                section_two = :section_two, 
                section_three = :section_three,
                created_at = :created_at
            WHERE id = :id";

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

    // FETCH ALL PENDING ARTICLES FROM DB - pending articles page - admin user
    protected function fetchAllPendingArticles(): array
    {
        $updatedQuery = "`status` = 'pending' ORDER BY created_at DESC";

        return $this->fetchArticles($updatedQuery);
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

    // CHECK IF ARTICLE BOOKMARKED - reader user
    protected function isArticleBookmarked(array $bookmarkParams): bool
    {
        try {
            return (bool) $this->dbQuery("SELECT * FROM bookmarked WHERE user_id = :user_id AND article_id = :article_id", $bookmarkParams)->fetch();
        } catch (Exception $e) {
            ErrorController::randomError();
            exit;
        }
    }

    // FETCH BOOKMARKED ARTICLES ID FROM bookmarked TABLE/DB  - reader user
    protected function fetchBookmarkedArticlesId(array $user): array
    {
        $userId = [
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
    protected function addBookmark(array $bookmarkParams, string $backPath, string $articleId): void
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
    protected function removeBookmark(array $newBookmark, string $backPath, string $articleId): void
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

    // FETCH BOOKMARKED ARTICLES FROM articles TABLE/DB  - reader user
    protected function fetchBookmarkedArticles(array $placeholders, array $params): array
    {
        $updatedQuery = "id IN (" . implode(', ', $placeholders) . ")";

        return $this->fetchArticles($updatedQuery, $params);
    }
}
