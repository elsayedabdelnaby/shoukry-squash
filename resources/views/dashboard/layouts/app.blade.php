<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
<!--begin::Head-->

<head>
    <meta charset="utf-8" />
    {{--    <title>@yield('title') {{ '-' . config('app.name') }}</title> --}}
    <meta name="description"
        content="Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="{{ request()->url() }}" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    @yield('head-css')
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ url(asset('public/metronic/assets/plugins/global/plugins.bundle.css')) }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ url(asset('public/metronic/assets/plugins/custom/prismjs/prismjs.bundle.css')) }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ url(asset('public/metronic/assets/css/style.bundle.css')) }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ url(asset('public/metronic/assets/css/themes/layout/header/base/light.css')) }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ url(asset('public/metronic/assets/css/themes/layout/header/menu/light.css')) }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ url(asset('public/metronic/assets/css/themes/layout/brand/dark.css')) }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ url(asset('public/metronic/assets/css/themes/layout/aside/dark.css')) }}" rel="stylesheet"
        type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!--end::Global Stylesheets Bundle-->
    <link href="{{ asset('css/dashboard/custom.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script>
        if ('Notification' in window) {
            Notification.requestPermission();
        }
    </script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <!--begin::Main-->
    <!--begin::Header Mobile-->
    @include('dashboard.layouts.partials.header_mobile')
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Aside-->
            @if (in_array(Auth()->user()->type, ['merchant', 'merchant_employee', 'merchant_manager']))
                @include('merchants::layouts.sidebar')
            @else
                @include('dashboard.layouts.partials.sidebar')
            @endif
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Header-->
                @include('dashboard.layouts.partials.header')
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Subheader-->
                    @yield('subheader')
                    <!--end::Subheader-->
                    <!--begin::Entry-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container-fluid">
                            <!--begin::Notice-->
                            @if (session('success'))
                                <x-dashboard.alert :type="'success'" :message="session('success')" />
                            @elseif(session('error'))
                                <x-dashboard.alert :type="'danger'" :message="session('error')" />
                            @endif

                            @if ($errors->any())
                                <x-dashboard.errors :$errors />
                            @endif
                            <!--end::Notice-->
                            @yield('content')
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Entry-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                @include('dashboard.layouts.partials.footer')
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!-- begin::User Panel-->
    @include('dashboard.layouts.partials.user_panel')
    <!-- end::User Panel-->
    <!--begin::Quick Panel-->
    @include('dashboard.layouts.partials.quick_panel')
    <!--end::Quick Panel-->
    <!--begin::Chat Panel-->
    @include('dashboard.layouts.partials.chat_panel')
    <!--end::Chat Panel-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop">
        <span class="svg-icon">
            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <polygon points="0 0 24 0 24 24 0 24" />
                    <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
                    <path
                        d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
                        fill="#000000" fill-rule="nonzero" />
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>
    </div>
    <!--end::Scrolltop-->
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1400
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#3699FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#E4E6EF",
                        "dark": "#181C32"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1F0FF",
                        "secondary": "#EBEDF3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#3F4254",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#EBEDF3",
                    "gray-300": "#E4E6EF",
                    "gray-400": "#D1D3E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#7E8299",
                    "gray-700": "#5E6278",
                    "gray-800": "#3F4254",
                    "gray-900": "#181C32"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ url(asset('public/metronic/assets/plugins/global/plugins.bundle.js')) }}"></script>
    <script src="{{ url(asset('public/metronic/assets/plugins/custom/prismjs/prismjs.bundle.js')) }}"></script>
    <script src="{{ url(asset('public/metronic/assets/js/scripts.bundle.js')) }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    @stack('javascript')
    <!--end::Page Scripts-->
    <script>
        function deleteRecord(deleteUrl,
            id,
            deleteCallBack,
            warningMessage = "{{ __('dashboard.you_cannot_be_able_to_revert_this') }}!") {
            Swal.fire({
                title: '{{ __('dashboard.are_you_sure') }}',
                text: warningMessage,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __('dashboard.yes_delete_it') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            "id": id
                        },
                        success: function(response) {
                            Swal.fire(
                                '{{ __('dashboard.deleted') }}!',
                                '{{ __('dashboard.the_record_has_been_deleted_successfully') }}.',
                                'success'
                            );
                            deleteCallBack();
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: '{{ __('dashboard.oops') }}...',
                                text: xhr.responseText,
                                icon: 'error',
                            });
                        }
                    });
                }
            });
        }

        $(document).on('change', '.toggle', function() {
            const checkbox = $(this);
            $.ajax({
                url: $(this).data('toggle-url'),
                type: 'PUT',
                dataType: 'json',
                data: {
                    "id": $(this).data('id'),
                    'name': $(this).data('name'),
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            title: '',
                            text: response.message,
                            icon: 'success',
                        });
                    } else {
                        $(checkbox).prop("checked", !$(checkbox).prop("checked"));
                        Swal.fire({
                            title: '{{ __('dashboard.oops') }}...',
                            text: response.message,
                            icon: 'error',
                        });
                    }
                },
                error: function(xhr) {
                    $(checkbox).prop("checked", !$(checkbox).prop("checked"));
                    let message = `<ul style="list-style-type: none;">`;
                    Object.entries(JSON.parse(xhr.responseText).errors).forEach(([key,
                        value
                    ]) => {
                        value.forEach((error) => {
                            message +=
                                `<li class="text-danger font-weight-bold">${value}</li>\n`;
                        });
                    })
                    message += '</ul>';
                    Swal.fire({
                        title: '{{ __('dashboard.oops') }}...',
                        html: message,
                        icon: 'error',
                    });
                }
            });
        });

        function openModal(modalId, url, id = null) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(response) {
                    $(`#${modalId}`).find('.modal-content').html(response.html);
                    $(`#${modalId}`).modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {

                }
            });
        }

        function showDeleteForm(recordId, deleteUrl, modalId) {
            $.ajax({
                type: 'GET',
                url: deleteUrl,
                dataType: 'json',
                data: {
                    "id": recordId
                },
                success: function(response) {
                    $(`#${modalId}`).find('.modal-content').html(response.html);
                    $(`#${modalId}`).modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {

                }
            });
        }
    </script>
</body>
<!--end::Body-->

</html>
