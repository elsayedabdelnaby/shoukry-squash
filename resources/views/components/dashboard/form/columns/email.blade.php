<div class="row">
    <label class="col-4 col-form-label font-weight-bold">{{ $label }}: </label>
    <div class="col-8">
        <input type="text" id="{{ $id }}" class="{{ $class }}" name="{{ $name }}"
            placeholder="{{ $label }}" value="{{ $value }}" {{ $attributes->merge([]) }}
            data-parsley-pattern="/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/"
            data-parsley-pattern-message="{{ $emailValidationMessage }}"
            @isset($isRequired)
                @if ($isRequired)
                    required
                    data-parsley-required-message="{{ $requiredMessage }}"
                @endif
            @endisset />
    </div>
</div>
