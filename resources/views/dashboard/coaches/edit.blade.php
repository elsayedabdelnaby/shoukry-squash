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
                            :name="'name'" :value="old('name', $coach->name ?? '')" :isRequired="true" :requiredMessage="__('dashboard.name_is_required')" :maxlength="255"
                            :maxlengthMessage="__('dashboard.number_of_characters_must_less_than_or_equal_255')" />
                    </div>
                    <!-- END Name -->
                    <!-- Address -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.text :label="__('dashboard.title')" :id="'title'" :class="'form-control'"
                            :name="'title'" :value="old('title', $coach->title ?? '')" :isRequired="true" :requiredMessage="__('dashboard.title_is_required')" :maxlength="255"
                            :maxlengthMessage="__('dashboard.number_of_characters_must_less_than_or_equal_255')" />
                    </div>
                    <!-- End Address -->
                </div>
                <div class="form-group row">
                    <!-- Facebook URL -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.url :id="'facebook_url'" :class="'form-control'" :name="'facebook_url'"
                            :label="__('dashboard.facebook_url')" :value="old('facebook_url', $coach->facebook_url ?? '')" :urlValidationMessage="__('dashboard.facebook_url_must_be_in_url_format')" />
                    </div>
                    <!-- End Facebook URL -->
                    <!-- Instagram -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.url :id="'instagram_url'" :class="'form-control'" :name="'instagram_url'"
                            :label="__('dashboard.instagram_url')" :value="old('instagram_url', $coach->instagram_url ?? '')" :urlValidationMessage="__('dashboard.instagram_url_must_be_in_url_format')" />
                    </div>
                    <!-- End Instagram -->
                </div>
                <div class="form-group row">
                    <!-- Twitter URL -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.url :id="'twitter_url'" :class="'form-control'" :name="'twitter_url'"
                            :label="__('dashboard.twitter_url')" :value="old('twitter_url', $coach->twitter_url ?? '')" :urlValidationMessage="__('dashboard.twitter_url_must_be_in_url_format')" />
                    </div>
                    <!-- End Twitter URL -->
                    <!-- Brief -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.text :label="__('dashboard.brief')" :id="'brief'" :class="'form-control'"
                            :name="'brief'" :value="old('brief', $coach->brief ?? '')" :maxlength="255" :maxlengthMessage="__('dashboard.number_of_characters_must_less_than_or_equal_255')" />
                    </div>
                    <!-- End Brief -->
                </div>
                <div class="form-group row">
                    <!-- Is Active -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.success-switch class="mx-2" :label="__('dashboard.is_active')" :id="'is_active'"
                            :name="'is_active'" :isChecked="old('is_active', $coach->is_active ?? '')" />
                    </div>
                    <!-- END Is Active -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <div class="row align-items-center">
                            <label
                                class="col-md-4 col-xl-4 col-lg-4 col-form-label text-left">{{ __('dashboard.image') }}</label>
                            <div class="col-md-8 col-lg-8 col-xl-8">
                                <div class="image-input image-input-empty image-input-outline"
                                    style="background-image: url('{{ $coach->image_url ?? asset('public/metronic/assets/media/users/blank.png') }}')"
                                    id="image">
                                    <div class="image-input-wrapper"></div>
                                    <label
                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                        data-action="change" data-toggle="tooltip" title=""
                                        data-original-title="{{ __('dashboard.change_image') }}">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="image" accept=".png, .jpg, .jpeg, .svg"
                                            @if (!isset($coach)) required @endif />
                                        <input type="hidden" name="image_remove" />
                                    </label>

                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                        data-action="cancel" data-toggle="tooltip"
                                        title="{{ __('dashboard.cancel_image') }}">
                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                    </span>

                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                        data-action="remove" data-toggle="tooltip"
                                        title="{{ __('dashboard.remove_image') }}">
                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <script src="{{ url(asset('public/metronic/assets/plugins/custom/uppy/uppy.bundle.js')) }}"></script>
    <!--end::Form JS-->
    <script>
        $(document).ready(function() {
            new KTImageInput('image');
        });
    </script>
@endpush
