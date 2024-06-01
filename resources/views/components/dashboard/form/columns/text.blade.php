<div class="row">
    <label class="col-4 col-form-label font-weight-bold">{{ $label }}: </label>
    <div class="col-8">
        <input type="text" id="{{ $id }}" class="{{ $class }}" name="{{ $name }}"
            placeholder="{{ $label }}" value="{{ $value }}" {{ $attributes->merge([]) }}
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
    </div>
</div>
