<input type="text" id="{{ $id }}" class="{{ $class }}" name="{{ $name }}"
    placeholder="{{ $placeholder }}" value="{{ $value }}" {{ $attributes->merge([]) }}
    @isset($isRequired)
        @if ($isRequired)
            required
            data-parsley-required-message="{{ $requiredMessage }}"
        @endif
    @endisset
    @isset($disabled)
        disabled
    @endisset
    @isset($readonly)
        readonly
    @endisset
    @isset($maxlength)
        maxlength="{{ $maxlength }}"
        data-parsley-maxlength="{{ $maxlength }}"
        data-parsley-maxlength-message="{{ $maxlengthMessage }}"
    @endisset />
