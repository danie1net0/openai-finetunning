@props([
  'title' => '',
  'colspan' => 1,
])

<th
  {{ $attributes->class(['px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider']) }}
  colspan="{{ $colspan }}"
>
  {{ $title ?? $slot }}
</th>