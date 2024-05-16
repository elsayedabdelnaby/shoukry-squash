@extends('dashboard.layouts.app')

@section('title', __('dashboard.package') . ' - ' . __('dashboard.edit_package'))

@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => __('dashboard.edit_package'),
        'short_description' => __('dashboard.enter_package_details_and_submit'),
        'breadcrumbs' => [],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ __('dashboard.edit_package') }}
                    <i class="mr-2"></i>
                    <small class=""></small>
                </h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <!--begin::Form-->
        <form class="form parsley-form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method($method)
            <div class="card-body">
                <div class="row form-group">
                    <!-- Name -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.text :label="__('dashboard.name')" :id="'name'" :class="'form-control'"
                            :name="'name'" :value="old('name', $package->name ?? '')" :isRequired="true" :requiredMessage="__('dashboard.name_is_required')" :maxlength="255"
                            :maxlengthMessage="__('dashboard.number_of_characters_must_less_than_or_equal_255')" />
                    </div>
                    <!-- END Name -->
                    <!-- Brief -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.text :label="__('dashboard.brief')" :id="'brief'" :class="'form-control'"
                            :name="'breif'" :value="old('breif', $package->breif ?? '')" :isRequired="true" :requiredMessage="__('dashboard.brief_is_required')" :maxlength="255"
                            :maxlengthMessage="__('dashboard.number_of_characters_must_less_than_or_equal_255')" />
                    </div>
                    <!-- End Brief -->
                </div>
                <div class="form-group row">
                    <!-- Sessions Number -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.number :id="'sessions_number'" :class="'form-control'" :name="'sessions_number'"
                            :isRequired="true" :requiredMessage="__('dashboard.sessions_number_is_required')" :integerValidationMessage="__('dashboard.must_be_number')" :label="__('dashboard.sessions_number')"
                            :value="old('sessions_number', $package->sessions_number ?? '')" />
                    </div>
                    <!-- End Sessions Number -->
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-10"></div>
                    <div class="col-2">
                        <button type="submit"
                            class="btn font-weight-bold btn-success mr-2  spinner-white spinner-right">{{ __('dashboard.save') }}</button>
                        <a href="{{ url()->previous() }}"
                            class="btn font-weight-bold btn-secondary">{{ __('dashboard.cancel') }}</a>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
@endsection

@push('javascript')
    <!-- Form Parsley Validation -->
    <script src="{{ asset('metronic/assets/plugins/parsley/parsley.min.js') }}"></script>
    <!--end::Form Parsley Validation-->
    <!-- Form JS -->
    <script src="{{ asset('js/form.js') }}"></script>
    <!--end::Form JS-->
@endpush
