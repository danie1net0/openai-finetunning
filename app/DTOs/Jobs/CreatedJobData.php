<?php

namespace App\DTOs\Jobs;

class CreatedJobData
{
    public function __construct(
        public string $id,
        public string $object,
        public string $model,
        public string $organizationId,
        public string $status,
        public int $createdAt,
        public ?string $fineTunedModel,
        public ?int $updatedAt,
        public ?int $finishedAt,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            object: $data['object'],
            model: $data['model'],
            organizationId: $data['organization_id'],
            status: $data['status'],
            createdAt: $data['created_at'],
            fineTunedModel: $data['fine_tuned_model'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
            finishedAt: $data['finished_at'] ?? null,
        );
    }
}
