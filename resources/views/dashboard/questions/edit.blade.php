@extends('dashboard.layouts.app')

@section('title', __('dashboard.question') . ' - ' . __('dashboard.edit_question'))

@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => __('dashboard.edit_question'),
        'short_description' => __('dashboard.enter_question_details_and_submit'),
        'breadcrumbs' => [],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ __('dashboard.edit_question') }}
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
                            :name="'name'" :value="old('name', $question->name ?? '')" :Disabled="true" :requiredMessage="__('dashboard.name_is_required')" />
                    </div>
                    <!-- END Name -->
                    <!-- Phone -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.text-area :id="''" :class="'form-control'" :name="'phone'"
                            :Disabled="true" :label="__('dashboard.phone')" :value="old('phone', $question->phone ?? '')" />
                    </div>
                    <!-- End Phone -->
                </div>
                <div class="form-group row">
                    <!-- Subject -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.text-area :id="'subject'" :class="'form-control'" :name="'subject'"
                            :label="__('dashboard.subject')" :value="old('subject', $question->subject ?? '')" :Disabled="true" />
                    </div>
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.text-area :id="''" :class="'form-control'" :name="'message'"
                            :Disabled="true" :label="__('dashboard.message')" :value="old('message', $question->message ?? '')" />
                    </div>
                    <!-- End Subject -->
                </div>
                <div class="form-group row">
                    <!-- Answer -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.text-area :id="''" :class="'form-control'" :name="'answer'"
                            :isRequired="true" :requiredMessage="__('dashboard.answer_is_required')" :label="__('dashboard.answer')" :value="old('answer', $question->answer ?? '')" />
                    </div>
                    <!-- END Answer -->
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
