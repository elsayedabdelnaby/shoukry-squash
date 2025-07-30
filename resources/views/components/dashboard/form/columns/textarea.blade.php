@props([
    'id' => null,
    'name' => null,
    'class' => 'form-control',
    'isRequired' => false,
    'requiredMessage' => 'This field is required.',
    'label' => null,
    'rows' => 3,
    'placeholder' => null,
    'value' => null,
])

<div class="form-group">
    @if($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if($isRequired)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    
    <textarea 
        id="{{ $id }}" 
        name="{{ $name }}" 
        class="{{ $class }} @error($name) is-invalid @enderror"
        rows="{{ $rows }}"
        @if($isRequired) required @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        {{ $attributes }}
    >{{ $value }}</textarea>
    
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
    
    @if($slot->isNotEmpty())
        <small class="form-text text-muted">
            {{ $slot }}
        </small>
    @endif
</div> 