<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Article
{
    public static function getLatestByCategory(int $categoryId, int $limit = 3): array
    {
        $stmt = Database::getInstance()->prepare('
            SELECT a.*
            FROM   articles a
            JOIN   article_categories ac ON ac.article_id = a.id
            WHERE  ac.category_id = :category_id
            ORDER  BY a.published_at DESC
            LIMIT  :limit
        ');
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getByCategoryPaginated(
        int $categoryId,
        string $sort,
        int $page,
        int $perPage
    ): array {
        $orderBy = $sort === 'views' ? 'a.views DESC' : 'a.published_at DESC';
        $offset = ($page - 1) * $perPage;

        $stmt = Database::getInstance()->prepare("
            SELECT a.*
            FROM   articles a
            JOIN   article_categories ac ON ac.article_id = a.id
            WHERE  ac.category_id = :category_id
            ORDER  BY {$orderBy}
            LIMIT  :limit OFFSET :offset
        ");
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function countByCategory(int $categoryId): int
    {
        $stmt = Database::getInstance()->prepare(
            'SELECT COUNT(*) FROM article_categories WHERE category_id = :category_id'
        );
        $stmt->execute(['category_id' => $categoryId]);
        return (int) $stmt->fetchColumn();
    }

    public static function getBySlug(string $slug): ?array
    {
        $stmt = Database::getInstance()->prepare('SELECT * FROM articles WHERE slug = :slug LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch() ?: null;
    }

    public static function incrementViews(int $id): void
    {
        $stmt = Database::getInstance()->prepare('UPDATE articles SET views = views + 1 WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public static function getSimilar(int $articleId, array $categoryIds, int $limit = 3): array
    {
        if (empty($categoryIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));

        $idStmt = Database::getInstance()->prepare("
            SELECT DISTINCT a.id
            FROM   articles a
            JOIN   article_categories ac ON ac.article_id = a.id
            WHERE  ac.category_id IN ({$placeholders})
              AND  a.id != ?
        ");
        $idStmt->execute([...$categoryIds, $articleId]);
        $ids = $idStmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($ids)) {
            return [];
        }

        shuffle($ids);
        $ids = array_slice($ids, 0, $limit);

        $placeholders2 = implode(',', array_fill(0, count($ids), '?'));
        $stmt = Database::getInstance()->prepare(
            "SELECT * FROM articles WHERE id IN ({$placeholders2})"
        );
        $stmt->execute($ids);
        return $stmt->fetchAll();
    }
}
