@extends('dashboard.layouts.app')
@section('title', isset($player) ? __('dashboard.edit_player') : __('dashboard.new_player'))
@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => isset($player) ? __('dashboard.edit_player') : __('dashboard.new_player'),
        'short_description' => __('dashboard.enter_player_details_and_submit'),
        'breadcrumbs' => [],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ isset($player) ? __('dashboard.edit_player') : __('dashboard.new_player') }}
                    <i class="mr-2"></i>
                    <small class=""></small>
                </h3>
            </div>
            <div class="card-toolbar"></div>
        </div>
        <form class="form parsley-form" action="{{ $action }}" method="POST">
            @csrf
            @method($method)
            <div class="card-body">
                <div class="row form-group">
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.text :id="'name'" :class="'form-control'" :name="'name'"
                            :isRequired="true" :requiredMessage="__('dashboard.name_is_required')" :label="__('dashboard.name')"
                            :value="old('name', $player->name ?? '')" />
                    </div>
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.text :id="'phone'" :class="'form-control'" :name="'phone'"
                            :isRequired="true" :requiredMessage="__('dashboard.phone_is_required')" :label="__('dashboard.phone')"
                            :value="old('phone', $player->phone ?? '')" />
                    </div>
                </div>
                
                <div class="row form-group">
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.date :id="'birth_date'" :class="'form-control'" :name="'birth_date'"
                            :isRequired="true" :requiredMessage="__('dashboard.birth_date_is_required')" :label="__('dashboard.birth_date')"
                            :value="old('birth_date', $player->birth_date ?? '')" />
                    </div>
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <div class="row">
                            <label class="col-4 col-form-label font-weight-bold" for="nationality">{{ __('dashboard.nationality') }}: </label>
                            <div class="col-8">
                                <select class="form-control" id="nationality" name="nationality" required data-parsley-required-message="{{ __('dashboard.nationality_is_required') }}">
                                    <option value="">{{ __('dashboard.select_nationality') }}</option>
                                    <option value="Egyptian" {{ (old('nationality', $player->nationality ?? '') == 'Egyptian') ? 'selected' : '' }}>Egyptian</option>
                                    <option value="Other" {{ (old('nationality', $player->nationality ?? '') == 'Other') ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row form-group">
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <div class="row">
                            <label class="col-4 col-form-label font-weight-bold" for="gender">{{ __('dashboard.gender') }}: </label>
                            <div class="col-8">
                                <select class="form-control" id="gender" name="gender" required data-parsley-required-message="{{ __('dashboard.gender_is_required') }}">
                                    <option value="">{{ __('dashboard.select_gender') }}</option>
                                    <option value="male" {{ (old('gender', $player->gender ?? '') == 'male') ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ (old('gender', $player->gender ?? '') == 'female') ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.text :id="'parents_contact_number'" :class="'form-control'" :name="'parents_contact_number'"
                            :isRequired="false" :label="__('dashboard.parents_contact_number')"
                            :value="old('parents_contact_number', $player->parents_contact_number ?? '')" />
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-10"></div>
                    <div class="col-2">
                        <button type="submit"
                            class="btn font-weight-bold btn-success mr-2  spinner-white spinner-right">{{ __('dashboard.save') }}</button>
                        <a href="{{ route('dashboard.players.index') }}"
                            class="btn font-weight-bold btn-secondary">{{ __('dashboard.cancel') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('javascript')
    <script src="{{ url(asset('public/metronic/assets/plugins/parsley/parsley.min.js')) }}"></script>
    <script src="{{ asset('js/form.js') }}"></script>
@endpush 