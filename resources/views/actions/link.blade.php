@component($typeForm, get_defined_vars())
    <a
        title="{{ $tooltip ?? '' }}"
        data-turbo="{{ var_export($turbo) }}"
        {{ $attributes }}
    >
        @isset($icon)
            <x-orchid-icon :path="$icon" class="{{ empty($name) ?: 'me-2'}}"/>
        @endisset

        <span>{{ $name ?? '' }}</span>
    </a>
@endcomponent
