<?php

use App\Services\OpenAi\OpenAiConnector;
use App\Support\Views\Actions;

use function Laravel\Folio\name;
use function Livewire\Volt\{computed, uses, state};

name('files.index');
uses([Actions::class]);

$fileResource = computed(fn () => app(OpenAiConnector::class)->files());

$files = computed(fn () => $this->fileResource->list());

$confirmDelete = fn (string $fileId) => $this->toast()->confirm([
    'title' => 'Delete file',
    'description' => 'Are you sure you want to delete this file?',
    'method' => 'delete',
    'params' => $fileId,
    'acceptLabel' => 'Delete',
    'rejectLabel' => 'Cancel',
]);

$delete = function (string $fileId) {
    $this->fileResource->delete($fileId);
    $this->toast()->success('Success!', 'File deleted successfully!');
}

?>

<div x-data>
  <x-layouts.dashboard title="Files">
    @volt()
      <x-slot name="header">
        Files

        <x-button icon="plus" content="File" x-on:click="location.href='{{ route('files.create') }}'"/>
      </x-slot>

      <x-table>
        <x-slot name="head">
          <x-table.head title="ID"/>
          <x-table.head title="Size"/>
          <x-table.head title="Created at"/>
          <x-table.head colspan="2" title="Status"/>
        </x-slot>

        @forelse($this->files as $file)
          <tr>
            <x-table.data :content="$file->id"/>
            <x-table.data>
              @fileSize($file->bytes)
            </x-table.data>

            <x-table.data>
              @dateTime($file->createdAt)
            </x-table.data>

            <x-table.data :content="$file->status"/>

            <x-table.data class="flex space-x-2.5">
              <a href="{{ route('files.show', ['id' => $file->id]) }}">
                <x-icons.eye class="text-gray-500 w-4"/>
              </a>

              <button wire:click="confirmDelete('{{ $file->id }}')">
                <x-icons.trash class="text-red-500 w-4"/>
              </button>
            </x-table.data>
          </tr>
        @empty
          <tr>
            <x-table.data colspan="5" content="No files found."/>
          </tr>
        @endforelse
      </x-table>
    @endvolt
  </x-layouts.dashboard>
</div>
