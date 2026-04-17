<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Category
{
    public static function getAllWithLatestArticles(int $limit = 3): array
    {
        $stmt = Database::getInstance()->prepare("
            SELECT
                c.id          AS cat_id,
                c.name        AS cat_name,
                c.slug        AS cat_slug,
                c.description AS cat_description,
                c.created_at  AS cat_created_at,
                a.id,
                a.title,
                a.slug,
                a.description,
                a.image,
                a.views,
                a.published_at
            FROM categories c
            JOIN (
                SELECT ac.category_id,
                       ac.article_id,
                       ROW_NUMBER() OVER (PARTITION BY ac.category_id ORDER BY a2.published_at DESC) AS rn
                FROM   article_categories ac
                JOIN   articles a2 ON a2.id = ac.article_id
            ) ranked ON ranked.category_id = c.id AND ranked.rn <= :limit
            JOIN articles a ON a.id = ranked.article_id
            ORDER BY c.name, ranked.rn
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $categories = [];
        foreach ($rows as $row) {
            $catId = $row['cat_id'];
            if (!isset($categories[$catId])) {
                $categories[$catId] = [
                    'id' => $row['cat_id'],
                    'name' => $row['cat_name'],
                    'slug' => $row['cat_slug'],
                    'description' => $row['cat_description'],
                    'created_at' => $row['cat_created_at'],
                    'articles' => [],
                ];
            }
            $categories[$catId]['articles'][] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'slug' => $row['slug'],
                'description' => $row['description'],
                'image' => $row['image'],
                'views' => $row['views'],
                'published_at' => $row['published_at'],
            ];
        }

        return array_values($categories);
    }

    public static function getBySlug(string $slug): ?array
    {
        $stmt = Database::getInstance()->prepare('SELECT * FROM categories WHERE slug = :slug LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch() ?: null;
    }

    public static function getByArticleId(int $articleId): array
    {
        $stmt = Database::getInstance()->prepare('
            SELECT c.*
            FROM   categories c
            JOIN   article_categories ac ON ac.category_id = c.id
            WHERE  ac.article_id = :article_id
        ');
        $stmt->execute(['article_id' => $articleId]);
        return $stmt->fetchAll();
    }
}
