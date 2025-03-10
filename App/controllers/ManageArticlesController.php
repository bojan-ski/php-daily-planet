<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\HasPermission;
use Framework\Session;

class ManageArticlesController extends ArticlesController
{
    private array $userId;
    public string $backPath;

    public function __construct()
    {
        parent::__construct();

        $this->userId = [
            'id' => Session::get('user')['id']
        ];

        $this->backPath = getPagePaths()[0];
    }

    // DISPLAY ALL AUTHOR ACTIVE ARTICLES PAGE - author user
    public function displayAuthorActiveArticlesPage(): void
    {
        $articles = $this->fetchAuthorActiveArticles($this->userId);

        loadView('articles', [
            'pageTitle' => 'My active articles',
            'articles' => $articles ?? ''
        ]);
    }

    // DISPLAY ALL AUTHOR PENDING ARTICLES PAGE - author user
    public function displayAuthorPendingArticlesPage(): void
    {
        $articles = $this->fetchAuthorPendingArticles($this->userId);

        loadView('articles', [
            'pageTitle' => 'My pending articles',
            'articles' => $articles ?? ''
        ]);
    }

    // DISPLAY SUBMIT NEW ARTICLE PAGE - author user
    public function displaySubmitNewArticlePage(): void
    {
        loadView('authorUser/submitNewArticle');
    }

    // SUBMIT NEW ARTICLE METHOD - author user
    public function submitArticle(): void
    {
        if (Session::exist('user') && Session::get('user')['role'] == 'author') {
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $section_one = isset($_POST['section_one']) ? $_POST['section_one'] : '';
            $section_two = isset($_POST['section_two']) ? $_POST['section_two'] : null;
            $section_three = isset($_POST['section_three']) ? $_POST['section_three'] : null;

            // check form data & display error if exist
            $errors = [];

            if (!isString($title, 5, 25)) {
                $errors['title'] = 'Please provide a valid title, between 5 and 25 characters';
            }
            if (!isString($description, 50, 250)) {
                $errors['description'] = 'Please provide a valid description, between 50 and 250 characters.';
            }
            if (!isString($section_one, 500, 2000)) {
                $errors['section_one'] = 'Please provide valid article content, between 500 and 2000 characters.';
            }
            if ($section_two && !isString($section_two, 500, 2000)) {
                $errors['section_two'] = 'Please provide valid article content, between 500 and 2000 characters.';
            }
            if ($section_three && !isString($section_three, 500, 2000)) {
                $errors['section_three'] = 'Please provide valid article content, between 500 and 2000 characters.';
            }

            if (!empty($errors)) {
                loadView('authorUser/submitNewArticle', [
                    'errors' => $errors,
                    'newArticle' => [
                        'title' => $title,
                        'description' => $description,
                        'section_one' => $section_one,
                        'section_two' => $section_two,
                        'section_three' => $section_three
                    ]
                ]);
                exit;
            }

            // if all is good -> submit article -> store in db
            $newArticle = [
                'title' => $title,
                'description' => $description,
                'section_one' => $section_one,
                'section_two' => $section_two,
                'section_three' => $section_three,
                'created_at' => date("Y-m-d h:i:s"),
                'user_id' => $this->userId['id'],
                'status' => 'pending'
            ];

            $this->createNewArticle($newArticle);

            // store pop up msg in session
            Session::set('pop_up', [
                'message' => 'Article submitted'
            ]);

            //redirect user 
            redirectUser('/my_pending_articles');
        } else {
            ErrorController::accessDenied();
            exit;
        }
    }

    // DISPLAY EDIT ARTICLE PAGE - author & admin user
    public function displayEditSelectedArticlePage(array $params): void
    {
        $selectedArticle = $this->fetchSelectedArticle($params);

        loadView('authorAndAdminUser/editSelectedArticle', [
            'selectedArticle' => $selectedArticle
        ]);
    }

    // EDIT ARTICLE METHOD - author & admin user
    public function editSelectedArticle(array $params): void
    {
        // get selected article - data
        $selectedArticle = $this->fetchSelectedArticle($params);

        // check if user has permission to edit
        if (!HasPermission::editOption($selectedArticle['status'], $selectedArticle['user_id'])) {
            ErrorController::accessDenied();
            exit;
        }

        // if user has permission to edit
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $section_one = isset($_POST['section_one']) ? $_POST['section_one'] : '';
        $section_two = isset($_POST['section_two']) ? $_POST['section_two'] : null;
        $section_three = isset($_POST['section_three']) ? $_POST['section_three'] : null;

        // check form data & display error if exist
        $errors = [];

        if (!isString($title, 5, 25)) {
            $errors['title'] = 'Please provide a valid title, between 5 and 25 characters';
        }
        if (!isString($description, 50, 250)) {
            $errors['description'] = 'Please provide a valid description, between 50 and 250 characters.';
        }
        if (!isString($section_one, 500, 2000)) {
            $errors['section_one'] = 'Please provide valid article content, between 500 and 2000 characters.';
        }
        if ($section_two && !isString($section_two, 500, 2000)) {
            $errors['section_two'] = 'Please provide valid article content, between 500 and 2000 characters.';
        }
        if ($section_three && !isString($section_three, 500, 2000)) {
            $errors['section_three'] = 'Please provide valid article content, between 500 and 2000 characters.';
        }

        if (!empty($errors)) {
            loadView('authorAndAdminUser/editSelectedArticle', [
                'errors' => $errors,
                'selectedArticle' => [
                    'id' => $selectedArticle['id'],
                    'title' => $title,
                    'description' => $description,
                    'section_one' => $section_one,
                    'section_two' => $section_two,
                    'section_three' => $section_three
                ]
            ]);
            exit;
        }

        // if all is good -> submit edited article -> update article in db
        $updatedSelectedArticle = [
            'id' => $selectedArticle['id'],
            'title' => $title,
            'description' => $description,
            'section_one' => $section_one,
            'section_two' => $section_two,
            'section_three' => $section_three,
            'created_at' => date("Y-m-d h:i:s")
        ];

        $this->editArticle($updatedSelectedArticle);

        // store pop up msg in session
        Session::set('pop_up', [
            'message' => 'Article updated'
        ]);

        //redirect user 
        redirectUser("/$this->backPath");
    }

    // DELETE ARTICLE METHOD - author & admin user
    public function deleteSelectedArticle(array $params): void
    {
        // get selected article - data
        $selectedArticle = $this->fetchSelectedArticle($params);

        if (HasPermission::isAllowed($selectedArticle['user_id'])) {
            $this->deleteArticle($params, $this->backPath);
        } else {
            ErrorController::accessDenied();
            exit;
        }
    }

    // DISPLAY ALL PENDING ARTICLES PAGE - admin user
    public function displayAllPendingArticlesPage(): void
    {
        $articles = $this->fetchAllPendingArticles();

        loadView('articles', [
            'pageTitle' => 'All pending articles',
            'articles' => $articles ?? ''
        ]);
    }

    // APPROVE ARTICLE METHOD - admin user
    public function approveSelectedArticle(array $params): void
    {
        $selectedArticle = $this->fetchSelectedArticle($params);

        if (HasPermission::approveOption($selectedArticle['status'])) {
            $this->approveArticle($params);
        } else {
            ErrorController::accessDenied();
            exit;
        }
    }
}
