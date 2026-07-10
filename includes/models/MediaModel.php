<?php

declare(strict_types=1);

class MediaModel extends BaseModel
{
    protected string $table = 'media';

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO media (filename, original_name, alt_text, file_size, mime_type) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['filename'], $data['original_name'], $data['alt_text'] ?? null,
            $data['file_size'] ?? 0, $data['mime_type'] ?? null,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function handleUpload(array $file): ?array
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $maxSize = config('upload.max_size', 5242880);
        $allowed = config('upload.allowed_types', []);

        if ($file['size'] > $maxSize) {
            return null;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowed, true)) {
            return null;
        }

        $ext = match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => 'bin',
        };

        $filename = uniqid('media_', true) . '.' . $ext;
        $dest = rtrim(config('upload.path'), '/\\') . DIRECTORY_SEPARATOR . $filename;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            return null;
        }

        $id = $this->create([
            'filename' => $filename,
            'original_name' => $file['name'],
            'file_size' => $file['size'],
            'mime_type' => $mime,
        ]);

        return $this->findById($id);
    }
}
