@blaze
@props(['value','icon'=> null])

<button
    {{ $attributes->merge(['class' => 'inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent']) }}><i class="{{$icon}}"></i> {{ $value }}</button>
