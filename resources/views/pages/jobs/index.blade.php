<?php

use App\Enums\Services\OpenAi\JobStatus;
use App\Services\OpenAi\OpenAiConnector;

use function Laravel\Folio\name;
use function Livewire\Volt\computed;

name('jobs.index');

$jobs = computed(fn () => app(OpenAiConnector::class)->jobs()->list());

?>

<div x-data>
  <x-layouts.dashboard title="jobs">
    @volt()
    <x-slot name="header">
      Jobs

      <x-button icon="plus" content="Job" x-on:click="location.href='{{ route('jobs.create') }}'"/>
    </x-slot>

    <x-table>
      <x-slot name="head">
        <x-table.head title="ID"/>
        <x-table.head title="Model"/>
        <x-table.head title="Tuned model"/>
        <x-table.head title="Status"/>
        <x-table.head colspan="2" title="Created at"/>
      </x-slot>

      @forelse($this->jobs as $job)
        <tr>
          <x-table.data :content="$job->id"/>
          <x-table.data :content="$job->model"/>
          <x-table.data :content="$job->fineTunedModel ?? '-'"/>
          <x-table.data :content="$job->status"/>

          <x-table.data>
            @dateTime($job->createdAt)
          </x-table.data>

          <x-table.data class="flex space-x-2.5">
            <a href="{{ route('jobs.show', ['id' => $job->id]) }}">
              <x-icons.eye class="text-gray-500 w-4"/>
            </a>
          </x-table.data>
        </tr>
      @empty
        <tr>
          <x-table.data colspan="5" content="No jobs found."/>
        </tr>
      @endforelse
    </x-table>
    @endvolt
  </x-layouts.dashboard>
</div>
