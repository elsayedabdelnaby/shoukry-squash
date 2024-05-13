<select class="form-control select2" name="{{ $name }}" id="{{ $id }}"
    @isset($isRequired)
        @if ($isRequired)
            required
            data-parsley-required-message="{{ $requiredMessage }}"
        @endif
    @endisset>
    @foreach ($weekDays as $day)
        <option value="{{ $day }}" @if ($day == $selectedOption) selected @endif>
            {{ $day }}
        </option>
    @endforeach
</select>
