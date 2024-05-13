<input type="text" id="{{ $id }}" class="{{ $class }}" name="meta_title"
    placeholder="{{ __('dashboard.meta_title') }}" value="{{ $value }}" {{ $attributes->merge([]) }}
    @isset($isRequired)
        @if ($isRequired)
            required
            data-parsley-required-message="{{ __('dashboard.meta_title_is_required') }}"
        @endif
    @endisset
    maxlength="65" data-parsley-maxlength="65"
    data-parsley-maxlength-message="{{ __('dashboard.number_of_characters_must_less_than_or_equal_65') }}" />
