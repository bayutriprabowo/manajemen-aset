<!-- resources/views/components/input.blade.php -->
@props(['id', 'name', 'type' => 'text', 'options' => [], 'value'])

{{-- <div>
    <label for="{{ $name }}">{{ $label }}</label>

    @if ($type === 'select')
        <select id="{{ $name }}" name="{{ $name }}" 
                @if ($required) required @endif
                @if ($autofocus) autofocus @endif
                autocomplete="{{ $autocomplete }}"
                class="block mt-1 w-full">
            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ $optionValue == old($name, $value) ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
    @else
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}"
               @if ($required) required @endif
               @if ($autofocus) autofocus @endif
               autocomplete="{{ $autocomplete }}"
               class="block mt-1 w-full">
    @endif

    @error($name)
    <span class="mt-2 text-red-600">{{ $message }}</span>
    @enderror
</div> --}}


<div>
    @if ($type === 'select')
        <select id="{{ $id }}" name="{{ $name }}" {!! $attributes->merge(['class' => 'form-select']) !!}>
            @foreach ($options as $key => $label)
                <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    @else
        <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}"
            value="{{ old($name, $value) }}" {!! $attributes->merge(['class' => 'form-input']) !!} />
    @endif
</div>
