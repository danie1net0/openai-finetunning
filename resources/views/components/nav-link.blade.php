@props([
    'route',
    'title',
    'active' => false,
    'mobile' => false,
])

<a
  @class([
    'inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium' => !$mobile,
    'block border-l-4 py-2 pl-3 pr-4 text-base font-medium' => $mobile,
    'border-indigo-500 text-gray-900' => $active && !$mobile,
    'border-indigo-500 bg-indigo-50 text-indigo-700' => $active && $mobile,
    'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' => !$active && !$mobile,
    'border-transparent text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800' => !$active && $mobile,
  ])
  href="{{ $route }}"
>
  {{ $title }}
</a>
