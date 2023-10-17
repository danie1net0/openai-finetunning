<?php

use App\Exceptions\Services\OpenAi\JobNotFoundException;
use App\Services\OpenAi\OpenAiConnector;

use function Laravel\Folio\name;
use function Livewire\Volt\{computed, state};

name('jobs.show');

state(['id' => static fn() => $id]);

state([
    'jobData' => function () {
        try {
            return (array)app(OpenAiConnector::class)->jobs()->retrieve($this->id);
        } catch (JobNotFoundException $exception) {
              abort(404);
        }
    },
]);

?>

<div>
  <x-layouts.dashboard title="Show job" :show-title="false">
    @volt()
    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
      <div class="px-4 py-6 sm:px-6">
        <h3 class="text-base font-semibold leading-7 text-gray-900">
          Job data
        </h3>

        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">
          Information about the job.
        </p>
      </div>

      <div class="border-t border-gray-100">
        <dl class="divide-y divide-gray-100">
          <x-pages.files.file-data title="Model" :content="$this->jobData['model']"/>
          <x-pages.files.file-data title="Tuned model" :content="$this->jobData['fineTunedModel']"/>
          <x-pages.files.file-data title="Training file" :content="$this->jobData['trainingFile']"/>
          <x-pages.files.file-data title="Object" :content="$this->jobData['object']"/>
          <x-pages.files.file-data title="Organization ID" :content="$this->jobData['organizationId']"/>
          <x-pages.files.file-data title="Validation file" :content="$this->jobData['validationFile'] ?? '-'"/>
          <x-pages.files.file-data title="Trained tokens" :content="json_encode($this->jobData['trainedTokens'])"/>
          <x-pages.files.file-data title="Status" :content="$this->jobData['status']"/>
          <x-pages.files.file-data title="Number of epochs" :content="$this->jobData['hyperParameters']['n_epochs']"/>

          <x-pages.files.file-data title="Result files">
            @splitArray($this->jobData['resultFiles'])
          </x-pages.files.file-data>

          <x-pages.files.file-data title="Created at">
            @dateTime($this->jobData['createdAt'])
          </x-pages.files.file-data>

          <x-pages.files.file-data title="Finished at">
            @dateTime($this->jobData['finishedAt'])
          </x-pages.files.file-data>
        </dl>
      </div>
    </div>
    @endvolt
  </x-layouts.dashboard>
</div>
