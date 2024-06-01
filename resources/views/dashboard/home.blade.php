@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard.dashboard') }}
@endsection

@section('head-css')
    <link href="{{ asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
@endsection

@section('subheader')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">

        </div>
    </div>
@endsection

@section('content')
    <!--begin::Dashboard-->
    <!--end::Dashboard-->
@endsection

@push('javascript')
    <script src="{{ asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/pages/widgets.js') }}"></script>
@endpush
