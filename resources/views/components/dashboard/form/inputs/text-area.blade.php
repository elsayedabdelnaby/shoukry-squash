<textarea id="{{ $id }}" name="{{ $name }}" class="{{ $class }}" {{ $attributes->merge([]) }}
    placeholder={{ $placeholder }}
    @isset($isRequired)
        @if ($isRequired)
        required
        data-parsley-required-message="{{ $requiredMessage }}"
        @endif
    @endisset
    @isset($maxlength)
        maxlength="{{ $maxlength }}"
        data-parsley-maxlength="{{ $maxlength }}"
        data-parsley-maxlength-message="{{ $maxlengthMessage }}"
    @endisset>
    @isset($value)
        {{ $value }}
    @endisset
</textarea>
