@props([
    'name',
    'label' => null,
])

<div>
  @if($label)
    <label for="{{ $name }}" class="block text-sm font-medium leading-6 text-gray-900">
      {{ $label }} @if($attributes->has('required')) <span class="text-red-600">*</span> @endif
    </label>
  @endif

  <input
    type="file"
    name="{{ $name }}"
    {{ $attributes->class(['block py-1.5 sm:text-sm sm:leading-6','text-red-900' => $errors->has($name) ]) }}>

    @error($name)
      <span class="mt-2 text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>
