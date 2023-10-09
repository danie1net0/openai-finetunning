<?php

use App\DTOs\Jobs\OutputJobData;
use App\Enums\Services\OpenAi\JobStatus;

uses()->group('unit', 'dtos', 'jobs');

test('create data', function (): void {
    $jobData = new OutputJobData(
        id: 'job-1',
        object: 'fine_tuning.job',
        model: 'personal-model',
        organizationId: 'org-id',
        trainingFile: 'file-1',
        validationFile: 'file-2',
        fineTunedModel: 'tuned-model',
        createdAt: 1695687805,
        finishedAt: 1696869147,
        trainedTokens: 1,
        status: JobStatus::SUCCEEDED,
        hyperParameters: [
            'n_epochs' => 1,
        ],
        resultFiles: [
            'file-3',
        ]
    );

    expect($jobData)->toBeInstanceOf(OutputJobData::class)
        ->id->toBe('job-1')
        ->object->toBe('fine_tuning.job')
        ->model->toBe('personal-model')
        ->fineTunedModel->toBe('tuned-model')
        ->organizationId->toBe('org-id')
        ->status->toBe(JobStatus::SUCCEEDED)
        ->createdAt->toBe(1695687805)
        ->updatedAt->toBeNull()
        ->finishedAt->toBe(1696869147)
        ->trainingFile->toBe('file-1')
        ->validationFile->toBe('file-2')
        ->trainedTokens->toBe(1)
        ->hyperParameters->toBe([
            'n_epochs' => 1,
        ])
        ->resultFiles->toBe([
            'file-3',
        ]);
});

test('create data from array', function (): void {
    $jobData = OutputJobData::fromArray([
        'id' => 'job-1',
        'object' => 'fine_tuning.job',
        'model' => 'personal-model',
        'fine_tuned_model' => 'tuned-model',
        'organization_id' => 'org-id',
        'status' => JobStatus::SUCCEEDED->value,
        'training_file' => 'file-1',
        'validation_file' => 'file-2',
        'trained_tokens' => 1,
        'created_at' => 1695687805,
        'finished_at' => 1696869147,
        'hyperparameters' => [
            'n_epochs' => 1,
        ],
    ]);

    expect($jobData)->toBeInstanceOf(OutputJobData::class)
        ->id->toBe('job-1')
        ->object->toBe('fine_tuning.job')
        ->model->toBe('personal-model')
        ->fineTunedModel->toBe('tuned-model')
        ->organizationId->toBe('org-id')
        ->status->toBe(JobStatus::SUCCEEDED)
        ->createdAt->toBe(1695687805)
        ->updatedAt->toBeNull()
        ->finishedAt->toBe(1696869147)
        ->trainingFile->toBe('file-1')
        ->validationFile->toBe('file-2')
        ->trainedTokens->toBe(1)
        ->hyperParameters->toBe([
            'n_epochs' => 1,
        ]);
});

test('create data from array without optional fields', function (): void {
    $outputJobData = OutputJobData::fromArray([
        'id' => 'job-1',
        'object' => 'fine_tuning.job',
        'model' => 'personal-model',
        'organization_id' => 'org-id',
        'status' => JobStatus::SUCCEEDED->value,
        'training_file' => 'file-1',
        'created_at' => 1695687805,
    ]);

    expect($outputJobData)->toBeInstanceOf(OutputJobData::class)
        ->id->toBe('job-1')
        ->object->toBe('fine_tuning.job')
        ->model->toBe('personal-model')
        ->organizationId->toBe('org-id')
        ->status->toBe(JobStatus::SUCCEEDED)
        ->trainingFile->toBe('file-1')
        ->createdAt->toBe(1695687805)
        ->fineTunedModel->toBeNull()
        ->updatedAt->toBeNull()
        ->finishedAt->toBeNull()
        ->validationFile->toBeNull()
        ->trainedTokens->toBeNull()
        ->hyperParameters->toBeEmpty()
        ->resultFiles->toBeEmpty();
});
