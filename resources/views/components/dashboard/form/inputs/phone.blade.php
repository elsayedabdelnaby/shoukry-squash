<input type="text" id="{{ $id }}" class="{{ $class }}" name="{{ $name }}"
    value="{{ $value }}" placeholder="{{ $placeholder }}" {{ $attributes->merge([]) }}
    data-parsley-pattern="/^[0-9]{5,13}$/" data-parsley-pattern-message="{{ $phoneValidationMessage }}"
    @isset($isRequired)
        @if ($isRequired)
            required
            data-parsley-required-message="{{ $requiredMessage }}"
        @endif
    @endisset />
