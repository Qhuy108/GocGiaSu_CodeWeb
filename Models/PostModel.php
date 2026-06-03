<?php
require_once __DIR__ . '/../core/Connect_DataBase.php';

class PostModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    public function getPublished(string $category = '', int $limit = 9, int $offset = 0): array
    {
        $where  = ["p.Status = 'published'"];
        $params = [];
        if ($category) {
            $where[]             = 'p.Category = :category';
            $params[':category'] = $category;
        }
        $sql = "SELECT p.*, u.Name AS author_name
                FROM posts p
                LEFT JOIN users u ON u.Id = p.Author_id
                WHERE " . implode(' AND ', $where) . "
                ORDER BY p.Created_at DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) $stmt->bindValue($k, $v);
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countPublished(string $category = ''): int
    {
        $where  = ["Status = 'published'"];
        $params = [];
        if ($category) {
            $where[]             = 'Category = :category';
            $params[':category'] = $category;
        }
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM posts WHERE " . implode(' AND ', $where));
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    public function findBySlug(string $slug): array|false
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, u.Name AS author_name FROM posts p
             LEFT JOIN users u ON u.Id = p.Author_id
             WHERE p.Slug = ? AND p.Status = 'published' LIMIT 1"
        );
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function getRelated(string $category, int $excludeId, int $limit = 3): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM posts WHERE Category = ? AND Id != ? AND Status = 'published'
             ORDER BY Created_at DESC LIMIT ?"
        );
        $stmt->execute([$category, $excludeId, $limit]);
        return $stmt->fetchAll();
    }

    public function getCategories(): array
    {
        $stmt = $this->db->query(
            "SELECT Category, COUNT(*) AS total FROM posts
             WHERE Status = 'published' GROUP BY Category ORDER BY total DESC"
        );
        return $stmt->fetchAll();
    }

    // Admin
    public function getAll(): array
    {
        return $this->db->query(
            "SELECT p.*, u.Name AS author_name FROM posts p
             LEFT JOIN users u ON u.Id = p.Author_id
             ORDER BY p.Created_at DESC"
        )->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE Id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO posts (Title, Slug, Summary, Content, Category, Image, Author_id, Status)
             VALUES (:Title,:Slug,:Summary,:Content,:Category,:Image,:Author_id,:Status)"
        );
        $stmt->execute($data);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $fields = array_map(fn($k) => "$k = :$k", array_keys($data));
        $stmt   = $this->db->prepare(
            "UPDATE posts SET " . implode(', ', $fields) . " WHERE Id = :id"
        );
        $data[':id'] = $id;
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE Id = ?");
        return $stmt->execute([$id]);
    }

    public function slugExists(string $slug, int $excludeId = 0): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM posts WHERE Slug = ? AND Id != ?");
        $stmt->execute([$slug, $excludeId]);
        return (int)$stmt->fetchColumn() > 0;
    }
}
