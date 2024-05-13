<div class="row align-items-center">
    <label class="col-9 col-sm-8 col-md-4 col-form-label font-weight-bold">{{ $label }}: </label>
    <div class="col-1">
        <span class="switch switch-outline switch-sm switch-icon switch-success">
            <label>
                <input {{ $attributes->merge([]) }} type="checkbox" @checked($isChecked)
                    name="{{ $name }}" id="{{ $id }}" @disabled(isset($isDisabled)) />
                <span></span>
            </label>
        </span>
    </div>
</div>
