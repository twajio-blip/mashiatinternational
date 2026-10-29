@props(['values', 'placeholder', 'selected','label_name','label_id'])
{{-- @dd($label_name); --}}
<select
    {{ $attributes->merge(['class' => 'py-3 px-4 pe-9 block w-full bg-skin-backend-secondary border-default border-opacity-25 text-skin-backend-text-base text-opacity-50 rounded-[4px] text-sm focus:outline-none focus:border-highlight focus:ring-0 disabled:opacity-50 disabled:pointer-events-none']) }}>
    @if ($placeholder)
        <option selected disabled value="">{{ $placeholder }}</option>
    @endif
    @foreach ($values as $key => $value)
        @if ($selected == $value[$label_id])
            <option value="{{ $value[$label_id] }}" selected>{{ ucfirst($value[$label_name]) }}</option>
        @else
            <option value="{{ $value[$label_id] }}">{{ ucfirst($value[$label_name]) }}</option>
        @endif
    @endforeach

</select>
