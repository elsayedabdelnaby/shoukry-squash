@extends('dashboard.layouts.app')

@section('title', __('dashboard.event') . ' - ' . __('dashboard.edit_event'))

@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => __('dashboard.edit_event'),
        'short_description' => __('dashboard.enter_event_details_and_submit'),
        'breadcrumbs' => [],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ __('dashboard.edit_event') }}
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
                    <!-- Title -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.text :label="__('dashboard.title')" :id="'title'" :class="'form-control'"
                            :name="'title'" :value="old('title', $event->title ?? '')" :isRequired="true" :requiredMessage="__('dashboard.title_is_required')" :maxlength="255"
                            :maxlengthMessage="__('dashboard.number_of_characters_must_less_than_or_equal_255')" />
                    </div>
                    <!-- END Title -->
                    <!-- Brief -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.text-area :id="''" :class="'form-control'" :name="'description'"
                            :isRequired="true" :requiredMessage="__('dashboard.description_is_required')" :label="__('dashboard.description')" :value="old('description', $event->description ?? '')" />
                    </div>
                    <!-- End Brief -->
                </div>
                <div class="form-group row">
                    <!-- Is Active -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.success-switch class="mx-2" :label="__('dashboard.show_in_home_page')" :id="'show_in_home_page'"
                            :name="'show_in_home_page'" :isChecked="old('show_in_home_page', $event->show_in_home_page ?? '')" />
                    </div>
                    <!-- End Is Active -->
                    <!-- Date -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.date :id="'date'" :class="'form-control'" :name="'date'"
                            :isRequired="true" :requiredMessage="__('dashboard.date')" :label="__('dashboard.date')" :value="old('date', $event->date ?? '')" />
                    </div>
                    <!-- END Date -->
                </div>
                <div class="form-group row">
                    <!-- Image Card -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <div class="row align-items-center">
                            <label
                                class="col-md-4 col-xl-4 col-lg-4 col-form-label text-left">{{ __('dashboard.image_card') }}</label>
                            <div class="col-md-8 col-lg-8 col-xl-8">
                                <div class="image-input image-input-empty image-input-outline"
                                    style="background-image: url('{{ $event->image_card_url ?? asset('public/metronic/assets/media/users/blank.png') }}')"
                                    id="image_card">
                                    <div class="image-input-wrapper"></div>
                                    <label
                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                        data-action="change" data-toggle="tooltip" title=""
                                        data-original-title="{{ __('dashboard.change_image') }}">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="image_card" accept=".png, .jpg, .jpeg, .svg"
                                            @if (!isset($event)) required @endif />
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
                    <!-- End Image Card -->
                    <!-- Horizontal Shot -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <div class="row align-items-center">
                            <label
                                class="col-md-4 col-xl-4 col-lg-4 col-form-label text-left">{{ __('dashboard.main_image') }}</label>
                            <div class="col-md-8 col-lg-8 col-xl-8">
                                <div class="image-input image-input-empty image-input-outline"
                                    style="background-image: url('{{ $event->main_image_url ?? asset('public/metronic/assets/media/users/blank.png') }}')"
                                    id="main_image">
                                    <div class="image-input-wrapper"></div>
                                    <label
                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                        data-action="change" data-toggle="tooltip" title=""
                                        data-original-title="{{ __('dashboard.change_image') }}">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="main_image" accept=".png, .jpg, .jpeg, .svg" />
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
                    <!-- END Horizontal Shot -->
                </div>
                <div class="form-group row">
                    <!-- Posters -->
                    <label class="col-2 col-md-2 col-lg-1 col-form-label font-weight-bold">{{ __('dashboard.posters') }}:
                    </label>
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4" id="input-posters">
                    </div>
                    <!-- END Posters -->
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
    <script src="{{ url(asset('public/metronic/assets/plugins/custom/jquery-image-uploader/image-uploader.min.js')) }}"></script>
    <script src="{{ url(asset('public/metronic/assets/plugins/custom/uppy/uppy.bundle.js')) }}"></script>
    <!--end::Form JS-->
    <script>
        var posters = {!! json_encode($posters) !!};
    </script>
    <script>
        var verticalShot = new KTImageInput('image_card');
        var horizontalShot = new KTImageInput('main_image');

        $('div#input-posters').imageUploader({
            imagesInputName: 'posters',
            preloaded: posters
        });
    </script>
@endpush
