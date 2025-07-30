@extends('dashboard.layouts.app')

@section('title', __('dashboard.branch_details') . ' - ' . $branch->name)

@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => __('dashboard.branch_details'),
        'short_description' => __('dashboard.view_branch_information'),
        'breadcrumbs' => [
            ['name' => __('dashboard.branches'), 'url' => route('dashboard.branches.index')],
            ['name' => $branch->name, 'url' => '#'],
        ],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ __('dashboard.branch_details') }} - {{ $branch->name }}
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('dashboard.branches.timetable', ['branch' => $branch]) }}"
                   class="btn btn-primary font-weight-bolder">
                    <i class="la la-calendar"></i>
                    {{ __('dashboard.branch_timetable') }}
                </a>
                <a href="{{ route('dashboard.branches.edit', ['branch' => $branch]) }}"
                   class="btn btn-secondary font-weight-bolder ml-2">
                    <i class="la la-edit"></i>
                    {{ __('dashboard.edit') }}
                </a>
                <a href="{{ route('dashboard.branches.index') }}"
                   class="btn btn-light font-weight-bolder ml-2">
                    <i class="la la-arrow-left"></i>
                    {{ __('dashboard.back') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.id') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $branch->id }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.name') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $branch->name }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.address') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $branch->address }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.location') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $branch->location ?? '-' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.starting_at') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $branch->starting_at }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.ending_at') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $branch->ending_at }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.number_of_courts') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $branch->number_of_courts }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.working_days') }}:</label>
                        <div class="col-8">
                            @if($branch->working_days)
                                @foreach(json_decode($branch->working_days) as $day)
                                    <span class="badge badge-info mr-1">{{ $day }}</span>
                                @endforeach
                            @else
                                <span class="form-control-plaintext">-</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Courts Section -->
    <div class="card card-custom mt-4">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    <i class="la la-map-marker"></i> {{ __('dashboard.courts') }} ({{ $branch->courts->count() }})
                </h3>
            </div>
        </div>
        <div class="card-body">
            @if($branch->courts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('dashboard.id') }}</th>
                                <th>{{ __('dashboard.name') }}</th>
                                <th>{{ __('dashboard.branch') }}</th>
                                <th>{{ __('dashboard.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($branch->courts as $court)
                                <tr>
                                    <td>{{ $court->id }}</td>
                                    <td>{{ $court->name }}</td>
                                    <td>{{ $court->branch->name }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.courts.edit', ['court' => $court]) }}"
                                           class="btn btn-sm btn-clean btn-icon" title="{{ __('dashboard.edit') }}">
                                            <i class="la la-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="la la-map-marker font-size-h1 text-muted"></i>
                    <h4 class="text-muted mt-3">{{ __('dashboard.no_courts') }}</h4>
                    <p class="text-muted">{{ __('dashboard.this_branch_has_no_courts_yet') }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection 