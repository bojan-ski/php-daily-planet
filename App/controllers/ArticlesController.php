<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ArticlesModels;
use Framework\Session;

class ArticlesController extends ArticlesModels
{
    private int $limit;

    public function __construct()
    {
        parent::__construct();

        $this->limit = (int) $_ENV['LIMIT'];
    }

    // DISPLAY ALL ACTIVE ARTICLES PAGE
    public function displayArticlesPage(): void
    {
        $articles = $this->fetchArticlesForArticlesPage($this->limit);

        loadView('articles', [
            'pageTitle' => 'All News',
            'articles' => $articles ?? ''
        ]);
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
        $articles = $this->searchResults($title);

        // load view
        if (empty($articles)) {
            // store pop up msg in session
            Session::set('pop_up', [
                'message' => 'No articles found for your search term'
            ]);

            //redirect user 
            redirectUser("/articles");
        } else {
            loadView('articles', [
                'pageTitle' => 'All News',
                'articles' => $articles,
                'search' => $title
            ]);
        }
    }

    // PAGINATION FEATURE FOR THE ALL ACTIVE ARTICLES PAGE
    public function loadMoreArticles(): void
    {
        $offset = isset($_POST['offset']) ? (int) $_POST['offset'] : 0;

        $articles = $this->pagination($this->limit, $offset);

        if (!empty($articles)) {
            foreach ($articles as $article) {
                loadPartial('articleCard', ['article' => $article]);
            }
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

        $selectedArticleAuthor = $this->fetchSelectedArticleAuthor($authorParams);

        // check if article is bookmarked - READER USER ONLY
        if (Session::exist('user') && Session::get('user')['role'] == 'reader') {
            $userId = Session::get('user')['id'] ?? '';
            $articleId = $params['id'] ?? '';

            $bookmarkParams = [
                'user_id' => $userId,
                'article_id' => $articleId
            ];

            $articleBookmarked = $this->isArticleBookmarked($bookmarkParams);

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
