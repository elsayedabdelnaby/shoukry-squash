<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5">
                    {{ $module_name }}
                </h5>
                <!--end::Page Title-->
                @if (isset($short_description))
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Search Form-->
                    <div class="d-flex align-items-center" id="kt_subheader_search">
                        <span class="text-dark-50 font-weight-bold"
                            id="kt_subheader_total">{{ $short_description }}</span>
                    </div>
                    <!--end::Search Form-->
                @else
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        @foreach ($breadcrumbs as $link)
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ $link['url'] }}" class="text-muted">{{ $link['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <!--end::Breadcrumb-->
                @endif
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Actions-->
            <a href="{{ URL::previous() }}"
                class="btn btn-light-primary font-weight-bolder btn-sm">{{ __('dashboard.back') }}</a>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar-->
    </div>
</div>
