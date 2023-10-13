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

<div>
  <x-layouts.dashboard title="Files">
    @volt()
      <x-table>
        <x-slot name="head">
          <x-table.head title="ID"/>
          <x-table.head title="Object"/>
          <x-table.head title="Bytes"/>
          <x-table.head title="Created At"/>
          <x-table.head title="Name"/>
          <x-table.head title="Purpose"/>
          <x-table.head colspan="2" title="Status"/>
        </x-slot>

        @forelse($this->files as $file)
          <tr>
            <x-table.data :content="$file->id"/>
            <x-table.data :content="$file->object"/>

            <x-table.data>
              @fileSize($file->bytes)
            </x-table.data>

            <x-table.data>
              @dateTime($file->createdAt)
            </x-table.data>

            <x-table.data :content="$file->fileName"/>
            <x-table.data :content="$file->purpose"/>
            <x-table.data :content="$file->status"/>

            <x-table.data>
              <button wire:click="confirmDelete('{{ $file->id }}')">
                <x-icons.trash class="text-red-500 w-4"/>
              </button>
            </x-table.data>
          </tr>
        @empty
          <tr>
            <x-table.data colspan="8" content="No files found."/>
          </tr>
        @endforelse
      </x-table>
    @endvolt
  </x-layouts.dashboard>
</div>
