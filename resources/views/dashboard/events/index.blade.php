@extends('dashboard.layouts.app')

@section('title', __('dashboard.events'))

@section('head-css')
    <link href="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
@endsection

@section('subheader')
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">{{ __('dashboard.events') }}
                    </h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('dashboard.events.index') }}"
                                class="text-muted">{{ __('dashboard.events') }}</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
@endsection
@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-body">

        </div>
    </div>
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="flaticon-squares text-primary"></i>
                </span>
                <h3 class="card-label">{{ __('dashboard.events') }}</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('dashboard.events.create') }}" class="btn btn-primary font-weight-bolder">
                    <i class="flaticon2-plus-1"></i>
                    {{ __('dashboard.new_event') }}</a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" style="margin-top: 13px !important">
                <thead>
                    <tr>
                        <th>{{ __('dashboard.id') }}</th>
                        <th>{{ __('dashboard.title') }}</th>
                        <th>{{ __('dashboard.date') }}</th>
                        <th>{{ __('dashboard.show_in_home_page') }}</th>
                        <th>{{ __('dashboard.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>
                                {{ $event->id }}
                            </td>
                            <td>
                                {{ $event->title }}
                            </td>
                            <td>
                                {{ $event->date }}
                            </td>
                            <td>
                                {{ $event->show_in_home_page }}
                            </td>
                            <td>
                                <a href="{{ route('dashboard.events.edit', ['event' => $event]) }}"
                                    class="btn btn-sm btn-clean btn-icon" title="{{ __('dashboard.edit') }}">
                                    <i class="la la-edit"></i>
                                </a>
                                <form action="{{ route('dashboard.events.destroy', ['event' => $event]) }}" method="post"
                                    class="d-inline-block">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-clean btn-icon"
                                        title="{{ __('dashboard.delete') }}">
                                        <i class="la la-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <!--end::Card-->
@endsection

@push('javascript')
    <script src="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush
