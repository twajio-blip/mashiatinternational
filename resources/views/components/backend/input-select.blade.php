@props(['values', 'placeholder', 'selected'])

<select
    {{ $attributes->merge(['class' => 'py-2 px-3 block w-full text-sm bg-skin-backend-secondary border focus:outline-none focus:border-highlight focus:ring-0 border-default border-opacity-25 text-skin-backend-text-base text-opacity-50 rounded-[4px] disabled:opacity-50 disabled:pointer-events-none']) }}>
    @if ($placeholder)
        <option selected disabled>{{ $placeholder }}</option>
    @endif
    @foreach ($values as $key => $value)
        @if ($selected == $key)
            <option value="{{ $key }}" selected>{{ ucfirst($value) }}</option>
        @else
            <option value="{{ $key }}">{{ ucfirst($value) }}</option>
        @endif
    @endforeach

</select>
