<div class="row form-group">
    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
        <x-dashboard.form.columns.text :label="__('dashboard.english_name')" :id="'english_name'" :class="'form-control'" :name="'english_name'"
            :value="$english_name" :isRequired="true" :requiredMessage="__('dashboard.english_name_is_required')" :maxlength="255" :maxlengthMessage="__('dashboard.number_of_characters_must_less_than_or_equal_255')" />
    </div>

    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
        <x-dashboard.form.columns.text :label="__('dashboard.arabic_name')" :id="'arabic_name'" :class="'form-control'" :name="'arabic_name'"
            :value="$arabic_name" :maxlength="255" :maxlengthMessage="__('dashboard.number_of_characters_must_less_than_or_equal_255')" />
    </div>
</div>
