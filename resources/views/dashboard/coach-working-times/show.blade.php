@extends('dashboard.layouts.app')

@section('title', __('dashboard.coach_working_time_details'))

@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => __('dashboard.coach_working_time_details'),
        'short_description' => __('dashboard.view_coach_working_time_information'),
        'breadcrumbs' => [],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ __('dashboard.coach_working_time_details') }}
                    <i class="mr-2"></i>
                    <small class=""></small>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('dashboard.coach-working-times.edit', ['coachWorkingTime' => $coachWorkingTime]) }}" 
                   class="btn btn-primary font-weight-bolder">
                    <i class="la la-edit"></i>
                    {{ __('dashboard.edit') }}
                </a>
                <a href="{{ route('dashboard.coach-working-times.index') }}" 
                   class="btn btn-secondary font-weight-bolder ml-2">
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
                            <span class="form-control-plaintext">{{ $coachWorkingTime->id }}</span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.coach') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $coachWorkingTime->coach->name }}</span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.week_day') }}:</label>
                        <div class="col-8">
                            <span class="badge badge-info">{{ $coachWorkingTime->week_day }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.start_time') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ \Carbon\Carbon::parse($coachWorkingTime->start_time)->format('H:i') }}</span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.end_time') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ \Carbon\Carbon::parse($coachWorkingTime->end_time)->format('H:i') }}</span>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-custom card-stretch">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">{{ __('dashboard.working_hours_summary') }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div class="font-size-h1 font-weight-bold text-primary">
                                            {{ \Carbon\Carbon::parse($coachWorkingTime->start_time)->diffInHours(\Carbon\Carbon::parse($coachWorkingTime->end_time)) }}
                                        </div>
                                        <div class="font-size-h6 text-muted">{{ __('dashboard.hours_per_day') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div class="font-size-h1 font-weight-bold text-info">
                                            {{ $coachWorkingTime->week_day }}
                                        </div>
                                        <div class="font-size-h6 text-muted">{{ __('dashboard.working_day') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 