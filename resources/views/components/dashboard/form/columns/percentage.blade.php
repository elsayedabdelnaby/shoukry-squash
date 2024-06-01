<div class="row">
    <label class="col-4 col-form-label font-weight-bold">{{ $label }}: </label>
    <div class="col-8">
        <input type="text" id="{{ $id }}" class="{{ $class }}" name="{{ $name }}"
            value="{{ $value }}" placeholder="{{ $label }}" {{ $attributes->merge([]) }}
            data-parsley-pattern="^100(\.0{1,2})?$|^\d{1,2}(\.\d{1,2})?$"
            data-parsley-pattern-message="{{ __('dashboard.please_enter_valid_percentage_(0-100)') }}"
            @isset($isRequired)
                @if ($isRequired)
                    required
                    data-parsley-required-message="{{ $requiredMessage }}"
                @endif
            @endisset />
    </div>
</div>
