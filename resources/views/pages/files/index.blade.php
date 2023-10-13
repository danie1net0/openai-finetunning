<?php

use App\Services\OpenAi\OpenAiService;
use function Laravel\Folio\name;
use function Livewire\Volt\{computed};

name('files.index');

$files = computed(fn(OpenAiService $openAiService) => $openAiService->files());

?>

<x-layouts.dashboard title="Files">
  @volt

  <div>

    {{--    <ul>--}}
    {{--      @foreach ($this->files as $file)--}}
    {{--        <li>--}}
    {{--          {{ $file['id'] }}--}}
    {{--        </li>--}}
    {{--      @endforeach--}}
    {{--    </ul>--}}
  </div>
</x-layouts.dashboard>
