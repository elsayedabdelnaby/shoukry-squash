<div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Header Menu Wrapper-->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">

        </div>
        <!--end::Header Menu Wrapper-->
        <!--begin::Topbar-->
        <div class="topbar">
            <!--begin::Languages-->
            <div class="dropdown">
                <!--begin::Toggle-->
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                    <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                        {{-- <img class="h-20px w-20px rounded-sm" src="{{ getCurrentLanguage()->icon_url }}"
                            alt="{{ getCurrentLanguage()->name }}" /> --}}
                    </div>
                </div>
                <!--end::Toggle-->
                <!--begin::Dropdown-->
                <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                    <!--begin::Nav-->
                    <ul class="navi navi-hover py-4">
                        {{-- @foreach (getAllActiveLanguages() as $language)
                            <!--begin::Item-->
                            <li class="navi-item @if ($language->code == getCurrentLanguage()->code) active @endif">
                                <a href="{{ LaravelLocalization::getLocalizedURL($language->code) }}" class="navi-link">
                                    <span class="symbol symbol-20 mr-3">
                                        <img src="{{ $language->icon_url }}" alt="{{ $language->name }}" />
                                    </span>
                                    <span class="navi-text">{{ $language->name }}</span>
                                </a>
                            </li>
                            <!--end::Item-->
                        @endforeach --}}
                    </ul>
                    <!--end::Nav-->
                </div>
                <!--end::Dropdown-->
            </div>
            <!--end::Languages-->
            <!--begin::User-->
            <div class="topbar-item">
                <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                    id="kt_quick_user_toggle">
                    <span
                        class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">{{ __('dashboard.hi') }},</span>
                    <span
                        class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ Auth()->user()->name }}</span>
                    <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                        <span class="symbol-label font-size-h5 font-weight-bold">{{ substr(Auth()->user()->name, 0, 1) }}</span>
                    </span>
                </div>
            </div>
            <!--end::User-->
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
