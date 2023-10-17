<?php

use App\DTOs\Jobs\OutputJobData;
use App\Enums\Services\OpenAi\JobStatus;
use App\Services\OpenAi\{jobsResource, OpenAiConnector};
use Illuminate\Support\Collection;

use function Pest\Laravel\{get, instance, partialMock};

it('should handle no jobs', function (): void {
    ($this->mockJobs)(collect());

    get(route('jobs.index'))
        ->assertOk()
        ->assertSee('No jobs found.');
});

it('should list jobs', function (): void {
    $jobs = collect([
        new OutputJobData(
            id: 'job-id-1',
            object: 'fine_tuning.job',
            model: 'personal-model-1',
            organizationId: 'org-id',
            trainingFile: 'file-1',
            validationFile: 'file-2',
            fineTunedModel: 'tuned-model-1',
            createdAt: now()->getTimestamp(),
            finishedAt: now()->addMinutes(10)->getTimestamp(),
            trainedTokens: 1,
            status: JobStatus::SUCCEEDED,
            hyperParameters: [
                'n_epochs' => 10,
            ],
            resultFiles: [
                'file-4',
            ]
        ),
        new OutputJobData(
            id: 'job-id-2',
            object: 'fine_tuning.job',
            model: 'personal-model-2',
            organizationId: 'org-id',
            trainingFile: 'file-4',
            validationFile: 'file-5',
            fineTunedModel: 'tuned-model-2',
            createdAt: now()->subDays()->getTimestamp(),
            finishedAt: now()->subDay()->addMinutes(10)->getTimestamp(),
            trainedTokens: 1,
            status: JobStatus::FAILED,
            hyperParameters: [
                'n_epochs' => 10,
            ],
            resultFiles: [
                'file-6',
            ]
        ),
    ]);

    ($this->mockJobs)($jobs);

    get(route('jobs.index'))
        ->assertOk()
        ->assertSee([
            'job-id-1',
            'personal-model-1',
            'tuned-model-1',
            str(JobStatus::SUCCEEDED->value)->ucfirst(),
            now()->format('Y-m-d H:i'),
        ])
        ->assertSee([
            'job-id-1',
            'personal-model-2',
            'tuned-model-2',
            str(JobStatus::FAILED->value)->ucfirst(),
            now()->subDay()->format('Y-m-d H:i'),
        ]);
});

beforeEach(function (): void {
    $this->mockJobs = function (Collection $jobs): void {
        $mockedResource = partialMock(JobsResource::class);
        $mockedResource->shouldReceive('list')->andReturn($jobs);

        $mockedConnector = partialMock(OpenAiConnector::class);
        $mockedConnector->shouldReceive('jobs')->andReturn($mockedResource);
    };
});
