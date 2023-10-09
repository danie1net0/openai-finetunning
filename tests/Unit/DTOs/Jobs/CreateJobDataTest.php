<?php

use App\DTOs\Jobs\CreateJobData;

uses()->group('unit', 'dtos', 'jobs');

test('create data', function (): void {
    $CreatejobData = new CreateJobData(
        file: 'file-1',
        model: 'gpt-3.5-turbo',
        epochs: 1,
    );

    expect($CreatejobData)->toBeInstanceOf(CreateJobData::class)
        ->file->toBe('file-1')
        ->model->toBe('gpt-3.5-turbo')
        ->epochs->toBe(1);
});
