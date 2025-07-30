@extends('dashboard.layouts.app')

@section('title', isset($coachWorkingTime) ? __('dashboard.edit_coach_working_time') : __('dashboard.new_coach_working_time'))

@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => isset($coachWorkingTime) ? __('dashboard.edit_coach_working_time') : __('dashboard.new_coach_working_time'),
        'short_description' => __('dashboard.enter_coach_working_time_details_and_submit'),
        'breadcrumbs' => [],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ isset($coachWorkingTime) ? __('dashboard.edit_coach_working_time') : __('dashboard.new_coach_working_time') }}
                    <i class="mr-2"></i>
                    <small class=""></small>
                </h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <!--begin::Form-->
        <form class="form parsley-form" action="{{ $action }}" method="POST">
            @csrf
            @method($method)
            <div class="card-body">
                <div class="row form-group">
                    <!-- Coach -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <div class="row">
                            <label class="col-4 col-form-label font-weight-bold" for="coach_id">{{ __('dashboard.coach') }}: </label>
                            <div class="col-8">
                                <select class="form-control" id="coach_id" name="coach_id" required data-parsley-required-message="{{ __('dashboard.coach_is_required') }}">
                                    <option value="">{{ __('dashboard.select_coach') }}</option>
                                    @foreach ($coaches as $coach)
                                        <option value="{{ $coach->id }}" {{ (old('coach_id', $coachWorkingTime->coach_id ?? $selectedCoachId ?? '') == $coach->id) ? 'selected' : '' }}>
                                            {{ $coach->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End Coach -->
                    <!-- Branch -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <div class="row">
                            <label class="col-4 col-form-label font-weight-bold" for="branch_id">{{ __('dashboard.branch') }}: </label>
                            <div class="col-8">
                                <select class="form-control" id="branch_id" name="branch_id">
                                    <option value="">{{ __('dashboard.select_branch') }} (Optional)</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ (old('branch_id', $coachWorkingTime->branch_id ?? '') == $branch->id) ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End Branch -->
                </div>
                <div class="row form-group">
                    <!-- Week Day -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <div class="row">
                            <label class="col-4 col-form-label font-weight-bold" for="week_day">{{ __('dashboard.week_day') }}: </label>
                            <div class="col-8">
                                <select class="form-control" id="week_day" name="week_day" required data-parsley-required-message="{{ __('dashboard.week_day_is_required') }}">
                                    <option value="">{{ __('dashboard.select_week_day') }}</option>
                                    @foreach ($weekDays as $day)
                                        <option value="{{ $day }}" {{ (old('week_day', $coachWorkingTime->week_day ?? '') == $day) ? 'selected' : '' }}>
                                            {{ $day }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End Week Day -->
                </div>
                <div class="form-group row">
                    <!-- Start Time -->
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.time :id="'start_time'" :class="'form-control'" :name="'start_time'"
                            :isRequired="true" :requiredMessage="__('dashboard.start_time_is_required')" :label="__('dashboard.start_time')" 
                            :value="old('start_time', $coachWorkingTime->start_time ?? '')" />
                    </div>
                    <!-- End Start Time -->
                    <!-- End Time -->
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.time :id="'end_time'" :class="'form-control'" :name="'end_time'"
                            :isRequired="true" :requiredMessage="__('dashboard.end_time_is_required')" :label="__('dashboard.end_time')" 
                            :value="old('end_time', $coachWorkingTime->end_time ?? '')" />
                    </div>
                    <!-- End End Time -->
                </div>
                
                @if ($errors->has('time_conflict'))
                    <div class="alert alert-danger">
                        <i class="la la-exclamation-triangle"></i>
                        {{ $errors->first('time_conflict') }}
                    </div>
                @endif
                
                <!-- Existing Time Slots for Selected Day -->
                <div id="existing-time-slots" class="mt-3" style="display: none;">
                    <div class="alert alert-info">
                        <h6><i class="la la-info-circle"></i> {{ __('dashboard.existing_time_slots_for_day') }}</h6>
                        <div id="time-slots-list"></div>
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
    
    <script>
        $(document).ready(function() {
            // Store coach working times data
            const coachWorkingTimes = @json($coachesWorkingTimes);
            
            function showExistingTimeSlots() {
                const coachId = $('#coach_id').val();
                const weekDay = $('#week_day').val();
                const branchId = $('#branch_id').val();
                
                if (coachId && weekDay) {
                    const coach = coachWorkingTimes.find(c => c.id == coachId);
                    if (coach && coach.working_times[weekDay]) {
                        let times = coach.working_times[weekDay];
                        
                        // Show all times for the day (not filtered by branch) to show potential conflicts
                        if (times.length > 0) {
                            let html = '<ul class="list-unstyled mb-0">';
                            times.forEach(function(time) {
                                const branchName = time.branch_id ? ` (Branch: ${getBranchName(time.branch_id)})` : ' (No Branch)';
                                const isSelectedBranch = branchId && time.branch_id == branchId;
                                const conflictClass = isSelectedBranch ? 'text-danger font-weight-bold' : 'text-warning';
                                html += `<li class="${conflictClass}"><i class="la la-clock"></i> ${time.start_time} - ${time.end_time}${branchName}</li>`;
                            });
                            html += '</ul>';
                            
                            // Add warning about cross-branch conflicts
                            if (branchId) {
                                html += '<div class="alert alert-warning mt-2">';
                                html += '<i class="la la-exclamation-triangle"></i> ';
                                html += '{{ __("dashboard.cross_branch_conflict_warning") }}';
                                html += '</div>';
                            }
                            
                            $('#time-slots-list').html(html);
                            $('#existing-time-slots').show();
                        } else {
                            $('#existing-time-slots').hide();
                        }
                    } else {
                        $('#existing-time-slots').hide();
                    }
                } else {
                    $('#existing-time-slots').hide();
                }
            }
            
            function getBranchName(branchId) {
                const branches = @json($branches);
                const branch = branches.find(b => b.id == branchId);
                return branch ? branch.name : 'Unknown Branch';
            }
            
            // Show existing time slots when coach, day, or branch changes
            $('#coach_id, #week_day, #branch_id').on('change', showExistingTimeSlots);
            
            // Show on page load if values are pre-selected
            showExistingTimeSlots();
        });
    </script>
@endpush 