@extends('dashboard.layouts.app')

@section('title', __('dashboard.court') . ' - ' . __('dashboard.edit_court'))

@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => __('dashboard.edit_court'),
        'short_description' => __('dashboard.enter_court_details_and_submit'),
        'breadcrumbs' => [],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ __('dashboard.edit_court') }}
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
                            :name="'name'" :value="old('name', $court->name ?? '')" :isRequired="true" :requiredMessage="__('dashboard.name_is_required')" :maxlength="255"
                            :maxlengthMessage="__('dashboard.number_of_characters_must_less_than_or_equal_255')" />
                    </div>
                    <!-- END Name -->
                    <!-- Branch -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.select :id="'branch_id'" :name="'branch_id'" :label="__('dashboard.branch')"
                            :options="$branches" :isMultiple="false" :defaultOptionName="__('dashboard.select_branch')" :selectedOption="old('branch_id', $court->branch_id ?? '')" />
                    </div>
                    <!-- End Branch -->
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
