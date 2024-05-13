<div class="row">
    <label class="col-4 col-form-label font-weight-bold">{{ $label }}: </label>
    <div class="col-8">
        <input type="text" id="{{ $id }}" class="{{ $class }}" name="{{ $name }}"
            value="{{ $value }}" placeholder="{{ $label }}" {{ $attributes->merge([]) }}
            @if ($acceptNegative)
                data-parsley-pattern="/^-?\d+(\.\d{1,2})?$/"
            @else
                data-parsley-pattern="/^\d+(\.\d{1,6})?$/"
            @endif
            data-parsley-pattern-message="{{ $decimalValdiationMessage }}"
            @isset($isRequired)
                @if ($isRequired)
                    required
                    data-parsley-required-message="{{ $requiredMessage }}"
                @endif
            @endisset />
    </div>
</div>
