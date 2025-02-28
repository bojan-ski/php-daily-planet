<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ArticlesModels;

class HomeController extends ArticlesModels
{
    public function latestArticles(): void
    {
        $articles = $this->fetchArticlesForHomePage();

        loadView('home', [
            'articles' => $articles ?? ''
        ]);
    }
}
