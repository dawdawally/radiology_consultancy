<?php

declare(strict_types=1);

class BlogModel extends BaseModel
{
    protected string $table = 'blog_posts';

    public function getCategories(): array
    {
        return $this->db->query('SELECT * FROM blog_categories ORDER BY name ASC')->fetchAll();
    }

    public function getPublished(int $limit = 0): array
    {
        $sql = 'SELECT p.*, c.name AS category_name, c.slug AS category_slug
                FROM blog_posts p
                LEFT JOIN blog_categories c ON c.id = p.category_id
                WHERE p.is_published = 1
                ORDER BY p.published_at DESC';
        if ($limit > 0) {
            $sql .= ' LIMIT ' . (int) $limit;
        }
        return $this->db->query($sql)->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.name AS category_name, c.slug AS category_slug
             FROM blog_posts p
             LEFT JOIN blog_categories c ON c.id = p.category_id
             WHERE p.slug = ? AND p.is_published = 1'
        );
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function createCategory(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO blog_categories (name, slug) VALUES (?, ?)');
        $stmt->execute([$data['name'], $data['slug']]);
        return (int) $this->db->lastInsertId();
    }

    public function createPost(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO blog_posts (category_id, slug, title, excerpt, content, featured_image, meta_title, meta_description, is_published, published_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['category_id'] ?: null, $data['slug'], $data['title'], $data['excerpt'],
            $data['content'], $data['featured_image'] ?? null, $data['meta_title'],
            $data['meta_description'], $data['is_published'] ?? 0, $data['published_at'] ?? null,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function updatePost(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE blog_posts SET category_id=?, slug=?, title=?, excerpt=?, content=?, featured_image=?, meta_title=?, meta_description=?, is_published=?, published_at=? WHERE id=?'
        );
        return $stmt->execute([
            $data['category_id'] ?: null, $data['slug'], $data['title'], $data['excerpt'],
            $data['content'], $data['featured_image'] ?? null, $data['meta_title'],
            $data['meta_description'], $data['is_published'] ?? 0, $data['published_at'] ?? null, $id,
        ]);
    }
}
