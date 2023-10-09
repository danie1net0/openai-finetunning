<?php

namespace App\DTOs\Jobs;

use App\Enums\Services\OpenAi\JobStatus;

class OutputJobData
{
    public function __construct(
        public string $id,
        public string $object,
        public string $model,
        public string $organizationId,
        public string $trainingFile,
        public ?string $validationFile,
        public ?string $fineTunedModel,
        public int $createdAt,
        public ?int $finishedAt,
        public ?int $trainedTokens,
        public JobStatus $status,
        public array $hyperParameters = [],
        public array $resultFiles = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            object: $data['object'],
            model: $data['model'],
            organizationId: $data['organization_id'],
            trainingFile: $data['training_file'],
            validationFile: $data['validation_file'] ?? null,
            fineTunedModel: $data['fine_tuned_model'] ?? null,
            createdAt: $data['created_at'],
            finishedAt: $data['finished_at'] ?? null,
            trainedTokens: $data['trained_tokens'] ?? null,
            status: JobStatus::tryFrom($data['status']),
            hyperParameters: $data['hyperparameters'] ?? [],
            resultFiles: $data['result_files'] ?? [],
        );
    }
}
