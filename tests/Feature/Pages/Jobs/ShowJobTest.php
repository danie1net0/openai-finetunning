<?php

use App\DTOs\Jobs\OutputJobData;
use App\Enums\Services\OpenAi\JobStatus;
use App\Exceptions\Services\OpenAi\JobNotFoundException;
use App\Services\OpenAi\{JobsResource, OpenAiConnector};

use function Pest\Laravel\{get, partialMock};

it('should handle no job', function (): void {
    $mockedResource = partialMock(JobsResource::class);
    $mockedResource->shouldReceive('retrieve')->andThrow(JobNotFoundException::class);

    $mockedConnector = partialMock(OpenAiConnector::class);
    $mockedConnector->shouldReceive('jobs')->andReturn($mockedResource);

    get(route('jobs.show', ['id' => 'job-id']))->assertNotFound();
});

it('should show job', function (): void {
    $job = new OutputJobData(
        id: 'job-id-1',
        object: 'fine_tuning.job',
        model: 'personal-model-1',
        organizationId: 'org-id',
        trainingFile: 'file-1',
        validationFile: 'file-2',
        fineTunedModel: 'tuned-model-1',
        createdAt: now()->getTimestamp(),
        finishedAt: now()->addMinutes(10)->getTimestamp(),
        trainedTokens: 10,
        status: JobStatus::SUCCEEDED,
        hyperParameters: [
            'n_epochs' => 10,
        ],
        resultFiles: [
            'job-4',
        ]
    );

    $mockedResource = partialMock(JobsResource::class);
    $mockedResource->shouldReceive('retrieve')->andReturn($job);

    $mockedConnector = partialMock(OpenAiConnector::class);
    $mockedConnector->shouldReceive('jobs')->andReturn($mockedResource);

    get(route('jobs.show', ['id' => $job->id]))
        ->assertOk()
        ->assertSee([
            $job->model,
            $job->fineTunedModel,
            $job->trainingFile,
            $job->object,
            $job->organizationId,
            $job->validationFile,
            $job->trainedTokens,
            str(JobStatus::SUCCEEDED->value)->ucfirst(),
            $job->hyperParameters['n_epochs'],
            $job->resultFiles[0],
            now()->format('Y-m-d H:i'),
            now()->addMinutes(10)->format('Y-m-d H:i'),
        ]);
});
