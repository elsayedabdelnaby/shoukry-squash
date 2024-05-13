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
            @foreach ($weekDays as $day)
                <option value="{{ $day }}" @if ($day == $selectedOption) selected @endif>
                    {{ $day }}
                </option>
            @endforeach
        </select>
    </div>
</div>
