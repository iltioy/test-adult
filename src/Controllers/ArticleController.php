<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Models\Category;

class ArticleController extends BaseController
{
    public function show(array $params): void
    {
        $article = Article::getBySlug($params['slug']);

        if ($article === null) {
            $this->notFound();
            return;
        }

        Article::incrementViews($article['id']);
        $article['views']++;

        $categories = Category::getByArticleId($article['id']);
        $categoryIds = array_column($categories, 'id');
        $similar = Article::getSimilar($article['id'], $categoryIds, 3);

        $this->render('pages/article.tpl', [
            'title' => $article['title'],
            'article' => $article,
            'categories' => $categories,
            'similar' => $similar,
        ]);
    }
}
