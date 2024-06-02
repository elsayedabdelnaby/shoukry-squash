@extends('dashboard.layouts.app')

@section('title', __('dashboard.branch') . ' - ' . __('dashboard.edit_branch'))

@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => __('dashboard.edit_branch'),
        'short_description' => __('dashboard.enter_branch_details_and_submit'),
        'breadcrumbs' => [],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ __('dashboard.edit_branch') }}
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
                            :name="'name'" :value="old('name', $branch->name ?? '')" :isRequired="true" :requiredMessage="__('dashboard.name_is_required')" :maxlength="255"
                            :maxlengthMessage="__('dashboard.number_of_characters_must_less_than_or_equal_255')" />
                    </div>
                    <!-- END Name -->
                    <!-- Address -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.text-area :id="''" :class="'form-control'" :name="'address'"
                            :isRequired="true" :requiredMessage="__('dashboard.address_is_required')" :label="__('dashboard.address')" :value="old('address', $branch->address ?? '')" />
                    </div>
                    <!-- End Address -->
                </div>
                <div class="form-group row">
                    <!-- Location -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.url :id="'location'" :class="'form-control'" :name="'location'"
                            :label="__('dashboard.location')" :value="old('location', $branch->location ?? '')" :urlValidationMessage="__('dashboard.location_must_be_in_url_format')" />
                    </div>
                    <!-- End Location -->
                </div>
                <div class="form-group row">
                    <!-- From -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.time :id="'working_from'" :class="'form-control'" :name="'working_from'"
                            :isRequired="true" :requiredMessage="__('dashboard.working_from_is_required')" :label="__('dashboard.working_from')" :value="old('working_from', $branch->working_from ?? '')" />
                    </div>
                    <!-- END From -->
                    <!-- To -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.time :id="'working_to'" :class="'form-control'" :name="'working_to'"
                            :isRequired="true" :requiredMessage="__('dashboard.working_to_is_required')" :label="__('dashboard.working_to')" :value="old('working_to', $branch->working_to ?? '')" />
                    </div>
                    <!-- END To -->
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
    <script src="{{ url(asset('public/metronic/assets/plugins/parsley/parsley.min.js')) }}"></script>
    <!--end::Form Parsley Validation-->
    <!-- Form JS -->
    <script src="{{ asset('js/form.js') }}"></script>
    <!--end::Form JS-->
@endpush
