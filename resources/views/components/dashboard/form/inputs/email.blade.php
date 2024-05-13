<input type="text" id="{{ $id }}" class="{{ $class }}" name="{{ $name }}"
    placeholder="{{ $placeholder }}" value="{{ $value }}" {{ $attributes->merge([]) }}
    data-parsley-pattern="/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/"
    data-parsley-pattern-message="{{ $emailValidationMessage }}"
    @isset($isRequired)
        @if ($isRequired)
            required
            data-parsley-required-message="{{ $requiredMessage }}"
        @endif
    @endisset />
