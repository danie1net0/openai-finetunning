<?php

use App\Services\OpenAi\OpenAiConnector;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use function Laravel\Folio\name;
use function Livewire\Volt\{computed, state};

name('jobs.show');

$jobResource = computed(fn() => app(OpenAiConnector::class)->jobs());

state(['id' => static fn() => $id]);

?>

<div>
  <x-layouts.dashboard title="Show job" :show-title="false">
    @volt()
    @endvolt
  </x-layouts.dashboard>
</div>
