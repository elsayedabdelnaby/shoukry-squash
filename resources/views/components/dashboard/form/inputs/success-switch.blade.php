<span class="switch switch-outline switch-sm switch-icon switch-success">
    <label>
        <input {{ $attributes->merge([]) }} type="checkbox" @checked($isChecked) name="{{ $name }}"
            id="{{ $id }}" @disabled(isset($isDisabled)) />
        <span></span>
    </label>
</span>
