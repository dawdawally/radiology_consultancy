<?php

declare(strict_types=1);

class MessageModel extends BaseModel
{
    protected string $table = 'messages';

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['name'], $data['email'], $data['phone'] ?? null,
            $data['subject'] ?? null, $data['message'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function getRecent(int $limit = 10): array
    {
        $stmt = $this->db->prepare('SELECT * FROM messages ORDER BY created_at DESC LIMIT ?');
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUnreadCount(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn();
    }

    public function markRead(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE messages SET is_read = 1 WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
