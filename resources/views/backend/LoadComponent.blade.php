

@foreach ($components as $key => $component)
    @component('components.frontend.' . $key, ['data' => $component])

    @endcomponent
@endforeach
