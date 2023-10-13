@props([
  'head' => null,
  'body' => null,
])

<table
  {{ $attributes->class(['table-auto min-w-full overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg']) }}
>
  @isset($head)
    <thead>
      {{ $head }}
    </thead>
  @endif

  <tbody class="bg-white">
    {{ $body ?? $slot }}
  </tbody>
</table>
