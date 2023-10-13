@props([
    'title',
    'content' => null,
])

<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
  <dt class="text-sm font-medium text-gray-900">
    {{ $title }}
  </dt>

  <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
    {{ $content ?? $slot }}
  </dd>
</div>
