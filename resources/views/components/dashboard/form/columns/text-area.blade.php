<div class="row">
    <label class="col-4 col-form-label font-weight-bold">{{ $label }}: </label>
    <div class="col-8">
        <textarea id="{{ $id }}" name="{{ $name }}" class="{{ $class }}" {{ $attributes->merge([]) }}
            placeholder={{ $label }}
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
    </div>
</div>
