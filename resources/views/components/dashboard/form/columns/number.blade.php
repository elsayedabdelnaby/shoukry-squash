@props([
    'id' => null,
    'name' => null,
    'class' => 'form-control',
    'isRequired' => false,
    'requiredMessage' => 'This field is required.',
    'integerValidationMessage' => 'This field must contain only numbers.',
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'step' => null,
    'min' => null,
    'max' => null,
])

<div class="row">
    <label class="col-4 col-form-label font-weight-bold">{{ $label }}: </label>
    <div class="col-8">
        <input type="number" 
            id="{{ $id }}" 
            class="{{ $class }}" 
            name="{{ $name }}"
            value="{{ $value }}" 
            placeholder="{{ $placeholder ?? $label }}" 
            @if($step) step="{{ $step }}" @endif
            @if($min) min="{{ $min }}" @endif
            @if($max) max="{{ $max }}" @endif
            {{ $attributes->merge([]) }}
            @if($isRequired)
                required
                data-parsley-required-message="{{ $requiredMessage }}"
            @endif />
    </div>
</div>
