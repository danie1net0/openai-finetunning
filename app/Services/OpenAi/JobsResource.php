<?php

namespace App\Services\OpenAi;

use App\DTOs\Jobs\{CreateJobData, OutputJobData};
use App\Exceptions\Services\OpenAi\{CompletedJobException, InvalidModelException, JobNotFoundException};
use Illuminate\Support\Collection;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Laravel\Facades\OpenAI;

class JobsResource
{
    /** @throws InvalidModelException */
    public function create(CreateJobData $jobData): OutputJobData
    {
        try {
            $response = OpenAI::fineTuning()->createJob([
                'training_file' => $jobData->file,
                'validation_file' => null,
                'model' => $jobData->model,
                'hyperparameters' => [
                    'n_epochs' => $jobData->epochs,
                ],
                'suffix' => null,
            ]);
        } catch (ErrorException $exception) {
            throw new InvalidModelException($exception->getMessage());
        }

        return OutputJobData::fromArray($response->toArray());
    }

    public function list(): Collection
    {
        $response = OpenAI::fineTuning()->listJobs([
            'limit' => 9,
        ]);

        return collect($response['data'])->map(fn (array $file) => OutputJobData::fromArray($file));
    }

    /** @throws JobNotFoundException */
    public function retrieve(string $file): OutputJobData
    {
        try {
            $response = OpenAI::fineTuning()->retrieveJob($file);
        } catch (ErrorException $exception) {
            throw new JobNotFoundException($exception->getMessage());
        }

        return OutputJobData::fromArray($response->toArray());
    }

    /** @throws CompletedJobException */
    public function cancel(string $file): OutputJobData
    {
        try {
            $response = OpenAI::fineTuning()->cancelJob($file);
        } catch (ErrorException $exception) {
            throw new CompletedJobException($exception->getMessage());
        }

        return OutputJobData::fromArray($response->toArray());
    }
}
