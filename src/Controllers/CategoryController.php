<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Models\Category;

class CategoryController extends BaseController
{
    private const PER_PAGE = 6;
    private const VALID_SORTS = ['date', 'views'];

    public function show(array $params): void
    {
        $category = Category::getBySlug($params['slug']);

        if ($category === null) {
            $this->notFound();
            return;
        }

        $sort = in_array($_GET['sort'] ?? '', self::VALID_SORTS, true)
            ? $_GET['sort']
            : 'date';

        $total = Article::countByCategory($category['id']);
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));
        $page = min(max(1, (int) ($_GET['page'] ?? 1)), $totalPages);

        $articles = Article::getByCategoryPaginated($category['id'], $sort, $page, self::PER_PAGE);

        $this->render('pages/category.tpl', [
            'title' => $category['name'],
            'category' => $category,
            'articles' => $articles,
            'sort' => $sort,
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
        ]);
    }
}
