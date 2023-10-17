<?php

use App\Livewire\Forms\FileForm;
use App\Services\OpenAi\OpenAiConnector;
use App\Support\Views\Actions;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

use function Laravel\Folio\name;
use function Livewire\Volt\{computed, form, uses};

name('files.create');
uses([Actions::class, WithFileUploads::class]);
form(FileForm::class);

$fileResource = computed(fn() => app(OpenAiConnector::class)->files());

$save = function () {
  /** @var TemporaryUploadedFile $file */
  $file = $this->form->validate()['file'];

  $this->fileResource->create($file->readStream());
  $this->form->reset('form.file');

  $this->toast()->success('Success!', 'File created successfully!');
}

?>

<x-layouts.dashboard title="Show file" :show-title="false">
  @volt()
    <form wire:submit="save" class="overflow-hidden bg-white shadow sm:rounded-lg">
      <div class="px-4 py-6 sm:px-6">
        <h3 class="text-base font-semibold leading-7 text-gray-900">
          Create file
        </h3>

        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">
          Send a new file.
        </p>
      </div>

      <div class="border-t border-gray-100 p-4">
        <x-forms.file accept=".jsonl" name="form.file" wire:model="form.file" label="JSONL file" required/>
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
