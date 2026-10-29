@props(['value'=> false, 'id', 'label' => null, 'checked' => false])

<div class="flex items-center">
    <input type="checkbox" value="{{ $value }}" id="{{ $id }}" name="{{ $attributes->get('name') }}"
        {{ $attributes->merge([
            'class' =>
                'shrink-0 border-[#e3e3e3] rounded text-skin-hover disabled:opacity-50 disabled:pointer-events-none focus:ring-0 focus:ring-offset-0 focus:outline-none focus:border-highlight',
        ]) }}
        @checked($checked)>
    <label for="{{ $id }}" class="text-sm text-skin-backend-text-base ms-3">
        {{ $label }}
    </label>
</div>
