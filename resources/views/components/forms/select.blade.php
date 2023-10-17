@props([
    'name',
    'options',
    'label' => null,
])

<div>
  @if($label)
    <label for="{{ $name }}" class="block text-sm font-medium leading-6 text-gray-900">
      {{ $label }} @if($attributes->has('required'))
        <span class="text-red-600">*</span>
      @endif
    </label>
  @endif

  <select
    name="{{ $name }}"
    {{ $attributes->class([
        'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
        'block py-1.5 sm:text-sm sm:leading-6',
        'text-red-900 ring-red-300 placeholder:text-red-400 focus:ring-red-600' => $errors->has($name),
    ]) }}
  >
    @if(!empty($options))
      <option value="" disabled>
        {{ $attributes->get('placeholder') ?? 'Select an option' }}
      </option>
    @endif

    @forelse($options as $optionKey => $optionValue)
      <option value="{{ $optionKey }}">{{ $optionValue }}</option>
    @empty
      <option value="" disabled>No options</option>
    @endforelse
  </select>

  @error($name)
    <span class="mt-2 text-sm text-red-600">{{ $message }}</span>
  @enderror
</div>
