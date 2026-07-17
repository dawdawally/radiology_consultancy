<?php

declare(strict_types=1);

class PageContentModel extends BaseModel
{
    protected string $table = 'page_content';

    public function getByKey(string $key): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM page_content WHERE page_key = ?');
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function getAllKeyed(): array
    {
        $rows = $this->findAll('page_key ASC');
        $keyed = [];
        foreach ($rows as $row) {
            $keyed[$row['page_key']] = $row;
        }
        return $keyed;
    }

    public function updatePage(string $key, array $data): bool
    {
        $fields = [];
        $values = [];
        foreach ($data as $field => $value) {
            $fields[] = "{$field} = ?";
            $values[] = $value;
        }
        $values[] = $key;
        $sql = 'UPDATE page_content SET ' . implode(', ', $fields) . ' WHERE page_key = ?';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function upsert(string $key, array $data): bool
    {
        if ($this->getByKey($key)) {
            return $this->updatePage($key, $data);
        }

        $columns = array_merge(['page_key'], array_keys($data));
        $placeholders = array_fill(0, count($columns), '?');
        $values = array_merge([$key], array_values($data));
        $sql = 'INSERT INTO page_content (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $placeholders) . ')';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }
}
