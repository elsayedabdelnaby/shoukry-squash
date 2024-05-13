<input type="datetime-local" id="{{ $id }}" class="{{ $class }}" name="{{ $name }}"
    placeholder="{{ $placeholder }}" value="{{ $value }}" {{ $attributes->merge([]) }}
    @isset($isRequired)
        @if ($isRequired)
            required
            data-parsley-required-message="{{ $requiredMessage }}"
        @endif
    @endisset
 />
