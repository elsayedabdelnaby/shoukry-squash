<textarea id="{{ $id }}" name="meta_description" class="{{ $class }}" {{ $attributes->merge([]) }}
    placeholder={{ __('dashboard.meta_description') }}
    @isset($isRequired)
        @if ($isRequired)
        required
        data-parsley-required-message="{{ __('dashboard.meta_description_is_required') }}"
        @endif
    @endisset
    maxlength="320" data-parsley-maxlength="320"
    data-parsley-maxlength-message="{{ __('dashboard.number_of_characters_must_less_than_or_equal_320') }}">
    @isset($value)
{{ $value }}
@endisset
</textarea>
