@props([
  'content' => null,
])

<td
  {{ $attributes->class(['px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500']) }}
>
  {{ $content ?? $slot }}
</td>
