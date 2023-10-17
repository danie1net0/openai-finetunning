<?php

use App\Enums\Services\OpenAi\TrainingModel;
use App\Livewire\Forms\JobForm;
use App\Services\OpenAi\OpenAiConnector;
use App\Support\Views\Actions;
use App\DTOs\Jobs\CreateJobData;

use function Laravel\Folio\name;
use function Livewire\Volt\{computed, form, uses};

name('jobs.create');
uses([Actions::class]);
form(JobForm::class);

$files = computed(fn() => app(OpenAiConnector::class)->files()->list()->pluck('id', 'id'));

$models = computed(fn() => collect(TrainingModel::cases())->pluck('value', 'value'));

$save = function () {
  $jobData = new CreateJobData(...$this->form->validate());

  try {
      app(OpenAiConnector::class)->jobs()->create($jobData);

      $this->toast()->success('Success!', 'Job created successfully!');
  } catch (Throwable $exception) {
      $this->toast()->error('Error!', $exception->getMessage());
  }
}

?>

<x-layouts.dashboard title="Create job" :show-title="false">
  @volt()
    <form wire:submit="save" class="overflow-hidden bg-white shadow sm:rounded-lg">
      <div class="px-4 py-6 sm:px-6">
        <h3 class="text-base font-semibold leading-7 text-gray-900">
          Create job
        </h3>

        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">
          Create a new job.
        </p>
      </div>

      <div class="border-t border-gray-100 p-4 flex flex-col gap-4">
        <x-forms.select
          required name="file"
          label="File"
          placeholder="Select a file"
          :options="$this->files"
          wire:model="form.file"
        />

        <x-forms.select
          required
          name="model"
          label="Model"
          placeholder="Select a model"
          :options="$this->models"
          wire:model="form.model"
        />

        <x-forms.input required type="number" min="10" name="epochs" label="Number of epochs" wire:model="form.epochs"/>
      </div>

      <div class="border-t border-gray-100 flex justify-end p-4">
        <x-button type="submit" wire:loading.attr="disabled">
          <span wire:loading.remove>Save</span>
          <span wire:loading>Saving...</span>
        </x-button>
      </div>
    </form>
  @endvolt
</x-layouts.dashboard>
