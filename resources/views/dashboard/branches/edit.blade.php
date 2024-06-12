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
                <div class="form-group row">
                    <!-- Working Days -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <div class="row">
                            <label class="col-4 col-form-label font-weight-bold" for="working_days">Working Days</label>
                            <div class="col-8">
                                <select multiple class="form-control" id="working_days" name="working_days[]">
                                    @foreach ($working_days as $day)
                                        <option value="{{ $day }}"
                                            @isset($branch)
@selected(in_array($day->value, explode(',', $branch->working_days)))
                                        @endisset>
                                            {{ $day }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- END Working Days -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <div class="row align-items-center">
                            <label
                                class="col-md-4 col-xl-4 col-lg-4 col-form-label text-left">{{ __('dashboard.image_card') }}</label>
                            <div class="col-md-8 col-lg-8 col-xl-8">
                                <div class="image-input image-input-empty image-input-outline"
                                    style="background-image: url('{{ $branch->image_url ?? asset('public/metronic/assets/media/users/blank.png') }}')"
                                    id="image">
                                    <div class="image-input-wrapper"></div>
                                    <label
                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                        data-action="change" data-toggle="tooltip" title=""
                                        data-original-title="{{ __('dashboard.change_image') }}">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="image" accept=".png, .jpg, .jpeg, .svg"
                                            @if (!isset($branch)) required @endif />
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
    <!--end::Form JS-->
    <script src="{{ url(asset('public/metronic/assets/plugins/custom/jquery-image-uploader/image-uploader.min.js')) }}">
    </script>
    <script src="{{ url(asset('public/metronic/assets/plugins/custom/uppy/uppy.bundle.js')) }}"></script>
    <!--end::Form JS-->
    <script>
        var verticalShot = new KTImageInput('image');
    </script>
@endpush
