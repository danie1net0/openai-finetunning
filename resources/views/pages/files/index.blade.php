<?php

use App\Services\OpenAi\OpenAiConnector;
use function Laravel\Folio\name;
use function Livewire\Volt\{computed};

name('files.index');

$files = computed(fn() => app(OpenAiConnector::class)->files()->list());

?>

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
        </tr>
      @empty
        <tr>
          <x-table.data colspan="8" content="No files found."/>
        </tr>
      @endforelse
    </x-table>
  @endvolt
</x-layouts.dashboard>
