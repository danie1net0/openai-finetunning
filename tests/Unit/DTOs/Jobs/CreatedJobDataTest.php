<?php

use App\DTOs\Jobs\CreatedJobData;

uses()->group('unit', 'dtos', 'jobs');

test('create data', function (): void {
    $createdJobData = new CreatedJobData(
        id: 'job-1',
        object: 'fine_tuning.job',
        model: 'personal-model',
        organizationId: 'org-id',
        status: 'succeeded',
        createdAt: 1695687805,
        fineTunedModel: 'tuned-model',
        updatedAt: 1695687898,
        finishedAt: 1696869147,
    );

    expect($createdJobData)->toBeInstanceOf(CreatedJobData::class)
        ->id->toBe('job-1')
        ->object->toBe('fine_tuning.job')
        ->model->toBe('personal-model')
        ->fineTunedModel->toBe('tuned-model')
        ->organizationId->toBe('org-id')
        ->status->toBe('succeeded')
        ->createdAt->toBe(1695687805)
        ->updatedAt->toBe(1695687898)
        ->finishedAt->toBe(1696869147);
});

test('create data from array', function (): void {
    $createdJobData = CreatedJobData::fromArray([
        'id' => 'job-1',
        'object' => 'fine_tuning.job',
        'model' => 'personal-model',
        'fine_tuned_model' => 'tuned-model',
        'organization_id' => 'org-id',
        'status' => 'succeeded',
        'created_at' => 1695687805,
        'updated_at' => 1695687898,
        'finished_at' => 1696869147,
    ]);

    expect($createdJobData)->toBeInstanceOf(CreatedJobData::class)
        ->id->toBe('job-1')
        ->object->toBe('fine_tuning.job')
        ->model->toBe('personal-model')
        ->fineTunedModel->toBe('tuned-model')
        ->organizationId->toBe('org-id')
        ->status->toBe('succeeded')
        ->createdAt->toBe(1695687805)
        ->updatedAt->toBe(1695687898)
        ->finishedAt->toBe(1696869147);
});

test('create data from array without optional fields', function (): void {
    $createdJobData = CreatedJobData::fromArray([
        'id' => 'job-1',
        'object' => 'fine_tuning.job',
        'model' => 'personal-model',
        'organization_id' => 'org-id',
        'status' => 'succeeded',
        'created_at' => 1695687805,
    ]);

    expect($createdJobData)->toBeInstanceOf(CreatedJobData::class)
        ->id->toBe('job-1')
        ->object->toBe('fine_tuning.job')
        ->model->toBe('personal-model')
        ->fineTunedModel->toBeNull()
        ->organizationId->toBe('org-id')
        ->status->toBe('succeeded')
        ->createdAt->toBe(1695687805)
        ->updatedAt->toBeNull();
});
