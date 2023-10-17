<?php

use App\Services\OpenAi\OpenAiConnector;
use App\Support\Views\Actions;
use Illuminate\Support\Facades\Storage;

use function Laravel\Folio\name;
use function Livewire\Volt\{computed, form, uses};

name('jobs.create');
uses([Actions::class]);

$jobsResource = computed(fn() => app(OpenAiConnector::class)->jobs());

$save = function () {
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

      <div class="border-t border-gray-100 p-4">
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
