<div class="row">
    <label class="col-4 col-form-label font-weight-bold">{{ $label }}: </label>
    <div class="col-8">
        <select class="form-control select2" name="{{ $name }}" id="{{ $id }}"
            @isset($isRequired)
                @if ($isRequired)
                    required
                    data-parsley-required-message="{{ $requiredMessage }}"
                @endif
            @endisset>
            <option value="">
                {{ $defaultOptionName }}
            </option>
            @foreach ($options as $option)
                <option value="{{ $option->value }}" @selected($option->value == $selectedOption)>
                    {{ __('dashboard.' . $option->name) }}
                </option>
            @endforeach
        </select>
    </div>
</div>
