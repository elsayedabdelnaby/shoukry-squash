@props([
    'id' => null,
    'name' => null,
    'class' => 'form-control',
    'isRequired' => false,
    'requiredMessage' => 'This field is required.',
    'label' => null,
    'accept' => null,
    'multiple' => false,
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
    
    <input 
        type="file" 
        id="{{ $id }}" 
        name="{{ $name }}" 
        class="{{ $class }} @error($name) is-invalid @enderror"
        @if($isRequired) required @endif
        @if($accept) accept="{{ $accept }}" @endif
        @if($multiple) multiple @endif
        {{ $attributes }}
    >
    
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