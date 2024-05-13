<div class="row">
    <label class="col-4 col-form-label font-weight-bold">{{ $label }}: </label>
    <div class="col-8">
        <input type="text" id="{{ $id }}" class="{{ $class }}" name="{{ $name }}"
            placeholder="{{ $label }}" value="{{ $value }}" {{ $attributes->merge([]) }}
            data-parsley-pattern="https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()!@:%_\+.~#?&\/\/=]*)|www\.?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()!@:%_\+.~#?&\/\/=]*)"
            data-parsley-pattern-message="{{ $urlValidationMessage }}"
            @isset($isRequired)
                @if ($isRequired)
                    required
                    data-parsley-required-message="{{ $requiredMessage }}"
                @endif
            @endisset />
    </div>
</div>
