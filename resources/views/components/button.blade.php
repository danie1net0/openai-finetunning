@props([
  'icon' => null,
  'content' => null,
])

<button
  {{ $attributes->class([
    "rounded-md bg-indigo-600 px-3 py-2 text-base text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600",
    'flex gap-x-1.5 items-center' => $icon,
  ]) }}
>
  @if($icon)
    <x-dynamic-component :component="'icons.' . $icon" class="h-[18px] w-[18px]"/>
  @endif

  {{ $content ?? $slot }}
</button>
