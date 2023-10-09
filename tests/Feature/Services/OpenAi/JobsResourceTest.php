<?php

use App\Enums\Services\OpenAi\JobStatus;
use App\Services\OpenAi\OpenAiConnector;
use Illuminate\Support\Collection;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\FineTunes\{ListResponse, RetrieveResponse};
use App\DTOs\Jobs\{CreateJobData, OutputJobData};
use OpenAI\Responses\FineTuning\{ListJobsResponse, RetrieveJobResponse};

uses()->group('feature', 'services', 'openai');

test('create job', function (): void {
    OpenAI::fake([
        RetrieveJobResponse::fake([
            'id' => 'job-id',
            'object' => 'fine_tuning.job',
            'model' => 'personal-model',
            'organization_id' => 'org-id',
            'status' => JobStatus::VALIDATING_FILES->value,
            'created_at' => 1695691885,
        ]),
    ]);

    $jobData = new CreateJobData('file-1', 'personal-model', 1);

    $job = (new OpenAiConnector())->jobs()->create($jobData);

    expect($job)
        ->toBeInstanceOf(OutputJobData::class)
        ->id->toBe('job-id')
        ->object->toBe('fine_tuning.job')
        ->model->toBe('personal-model')
        ->organizationId->toBe('org-id')
        ->status->toBe(JobStatus::VALIDATING_FILES)
        ->createdAt->toBe(1695691885);
});

test('list jobs', function (): void {
    OpenAI::fake([
        ListJobsResponse::fake([
            'data' => [
                $this->outputJobData,
            ],
        ]),
    ]);

    $jobs = (new OpenAiConnector())->jobs()->list();

    expect($jobs)
        ->toBeInstanceOf(Collection::class)
        ->and($jobs->first())
        ->id->toBe('job-1')
        ->object->toBe('fine_tuning.job')
        ->model->toBe('personal-model')
        ->fineTunedModel->toBe('tuned-model')
        ->organizationId->toBe('org-id')
        ->status->toBe(JobStatus::SUCCEEDED)
        ->createdAt->toBe(1695687805)
        ->finishedAt->toBe(1696869147)
        ->trainingFile->toBe('file-1')
        ->validationFile->toBe('file-2')
        ->trainedTokens->toBe(1)
        ->hyperParameters->toBe([
            'n_epochs' => 1,
        ]);
});

test('retrieve job', function (): void {
    OpenAI::fake([
        RetrieveJobResponse::fake($this->outputJobData),
    ]);

    $job = (new OpenAiConnector())->jobs()->retrieve('job-1');

    expect($job)
        ->toBeInstanceOf(OutputJobData::class)
        ->id->toBe('job-1')
        ->object->toBe('fine_tuning.job')
        ->model->toBe('personal-model')
        ->fineTunedModel->toBe('tuned-model')
        ->organizationId->toBe('org-id')
        ->status->toBe(JobStatus::SUCCEEDED)
        ->createdAt->toBe(1695687805)
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

test('cancel job', function (): void {
    $this->outputJobData['status'] = JobStatus::CANCELLED->value;

    OpenAI::fake([
        RetrieveJobResponse::fake($this->outputJobData),
    ]);

    $job = (new OpenAiConnector())->jobs()->cancel('file-1');

    expect($job)
        ->toBeInstanceOf(OutputJobData::class)
        ->id->toBe('job-1')
        ->object->toBe('fine_tuning.job')
        ->model->toBe('personal-model')
        ->fineTunedModel->toBe('tuned-model')
        ->organizationId->toBe('org-id')
        ->status->toBe(JobStatus::CANCELLED)
        ->createdAt->toBe(1695687805)
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

beforeEach(function (): void {
    $this->outputJobData = [
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
        'result_files' => [
            'file-3',
        ],
    ];
});
