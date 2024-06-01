<select  class="form-control select2" name="{{ $name }}" id="{{ $id }}"
    @isset($isRequired)
        @if ($isRequired)
            required
            data-parsley-required-message="{{ $requiredMessage }}"
        @endif
    @endisset
    @if ($isMultiple) multiple="multiple" @endif>
    <option value="" @disabled($isMultiple)>
        {{ $defaultOptionName }}
    </option>
    @foreach ($options as $option)
        <option value="{{ $option->id }}" @if ($isMultiple && is_array($selectedOption) && in_array($option->id, $selectedOption)) selected @endif
            @selected($option->id == $selectedOption)>
            {{ $option->name }}
        </option>
    @endforeach
</select>
