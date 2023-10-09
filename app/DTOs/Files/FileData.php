<?php

namespace App\DTOs\Files;

class FileData
{
    public function __construct(
        public string $id,
        public string $object,
        public int $bytes,
        public int $createdAt,
        public string $fileName,
        public string $purpose,
        public string $status,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['object'],
            $data['bytes'],
            $data['created_at'],
            $data['filename'],
            $data['purpose'],
            $data['status'],
        );
    }
}
