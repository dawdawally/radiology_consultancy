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

    public function createReply(int $messageId, int $adminId, string $subject, string $body, bool $emailSent): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO message_replies (message_id, admin_id, subject, body, email_sent) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([$messageId, $adminId, $subject, $body, $emailSent ? 1 : 0]);
        return (int) $this->db->lastInsertId();
    }

    public function getReplies(int $messageId): array
    {
        $stmt = $this->db->prepare(
            'SELECT r.*, u.full_name AS admin_name, u.username AS admin_username
             FROM message_replies r
             INNER JOIN admin_users u ON u.id = r.admin_id
             WHERE r.message_id = ?
             ORDER BY r.created_at ASC'
        );
        $stmt->execute([$messageId]);
        return $stmt->fetchAll();
    }
}
