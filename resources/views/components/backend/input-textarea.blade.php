@props(['text'])
<textarea
    {{ $attributes->merge(['class' => 'w-full text-[14px] bg-skin-backend-secondary rounded-[4px] border border-default border-opacity-25 focus:border-highlight focus:outline-none focus:ring-0 disabled:opacity-50 disabled:pointer-events-none text-skin-backend-text-base text-opacity-50 placeholder:text-skin-backend-text-base placeholder:text-opacity-50']) }}>{{ $text }}</textarea>
