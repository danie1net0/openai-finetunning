<?php

use App\Exceptions\Services\OpenAi\FileNotFoundException;
use App\Services\OpenAi\OpenAiConnector;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use function Laravel\Folio\name;
use function Livewire\Volt\{computed, state};

name('files.show');

$fileResource = computed(fn() => app(OpenAiConnector::class)->files());

state(['id' => static fn() => $id]);

state([
    'fileData' => function () {
        try {
            return (array)$this->fileResource->retrieve($this->id);
        } catch (FileNotFoundException $exception) {
            abort(404);
        }
    },
]);

$download = function () {
  $fileContent = $this->fileResource->download($this->id);
  $fileName = $this->id . '.jsonl';

  return response()->streamDownload(function () use ($fileContent) {
    echo $fileContent;
  }, $fileName);
}

?>

<div>
  <x-layouts.dashboard title="Show file" :show-title="false">
    @volt()
    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
      <div class="px-4 py-6 sm:px-6">
        <h3 class="text-base font-semibold leading-7 text-gray-900">
          File data
        </h3>

        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">
          Information about the file.
        </p>
      </div>

      <div class="border-t border-gray-100">
        <dl class="divide-y divide-gray-100">
          <x-pages.files.file-data title="Object" :content="$this->fileData['object']"/>

          <x-pages.files.file-data title="Created at">
            @dateTime($this->fileData['createdAt'])
          </x-pages.files.file-data>

          <x-pages.files.file-data title="Name" :content="$this->fileData['fileName']"/>
          <x-pages.files.file-data title="Purpose" :content="$this->fileData['purpose']"/>
          <x-pages.files.file-data title="Status" :content="$this->fileData['status']"/>

          <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium leading-6 text-gray-900">
              File
            </dt>

            <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                  <div class="flex w-0 flex-1 items-center">
                    <x-icons.paper-clip class="h-5 w-5 flex-shrink-0 text-gray-400"/>

                    <div class="ml-4 flex min-w-0 flex-1 gap-2">
                        <span class="truncate font-medium">
                          {{ $this->fileData['id'] }}.jsonl
                        </span>

                      <span class="flex-shrink-0 text-gray-400">
                          @fileSize($this->fileData['bytes'])
                        </span>
                    </div>
                  </div>

                  <div class="ml-4 flex-shrink-0">
                    <button wire:click="download" class="font-medium text-indigo-600 hover:text-indigo-500">
                      Download
                    </button>
                  </div>
                </li>
              </ul>
            </dd>
          </div>
        </dl>
      </div>
    </div>
    @endvolt
  </x-layouts.dashboard>
</div>
