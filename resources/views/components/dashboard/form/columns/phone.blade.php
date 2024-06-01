<div class="row">
    <label class="col-4 col-form-label font-weight-bold">{{ $label }}: </label>
    <div class="col-8">
        <input type="text" id="{{ $id }}" class="{{ $class }}" name="{{ $name }}"
            value="{{ $value }}" placeholder="{{ $label }}" {{ $attributes->merge([]) }}
            data-parsley-pattern="/^[0-9]{5,13}$/" data-parsley-pattern-message="{{ $phoneValidationMessage }}"
            @isset($isRequired)
                @if ($isRequired)
                    required
                    data-parsley-required-message="{{ $requiredMessage }}"
                @endif
            @endisset />
    </div>
</div>
