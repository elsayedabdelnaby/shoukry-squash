@extends('dashboard.layouts.app')
@section('title', isset($subscription) ? __('dashboard.edit_subscription') : __('dashboard.new_subscription'))
@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => isset($subscription) ? __('dashboard.edit_subscription') : __('dashboard.new_subscription'),
        'short_description' => __('dashboard.enter_subscription_details_and_submit'),
        'breadcrumbs' => [],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ isset($subscription) ? __('dashboard.edit_subscription') : __('dashboard.new_subscription') }}
                    <i class="mr-2"></i>
                    <small class=""></small>
                </h3>
            </div>
            <div class="card-toolbar"></div>
        </div>
        <form class="form parsley-form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method($method)
            <div class="card-body">
                <div class="row form-group">
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <div class="row">
                            <label class="col-4 col-form-label font-weight-bold" for="player_id">{{ __('dashboard.player') }}: </label>
                            <div class="col-8">
                                <select class="form-control" id="player_id" name="player_id" required data-parsley-required-message="{{ __('dashboard.player_id_is_required') }}">
                                    <option value="">{{ __('dashboard.select_player') }}</option>
                                    @foreach ($players as $player)
                                        <option value="{{ $player->id }}" 
                                            {{ (old('player_id', $subscription->player_id ?? $selectedPlayerId ?? '') == $player->id) ? 'selected' : '' }}
                                            data-nationality="{{ $player->nationality }}">
                                            {{ $player->name }} ({{ $player->nationality }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <div class="row">
                            <label class="col-4 col-form-label font-weight-bold" for="package_id">{{ __('dashboard.package') }}: </label>
                            <div class="col-8">
                                <select class="form-control" id="package_id" name="package_id" required data-parsley-required-message="{{ __('dashboard.package_id_is_required') }}">
                                    <option value="">{{ __('dashboard.select_package') }}</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}" 
                                            {{ (old('package_id', $subscription->package_id ?? '') == $package->id) ? 'selected' : '' }}
                                            data-price-egyptian="{{ $package->price_egyptian }}"
                                            data-price-other="{{ $package->price_other }}"
                                            data-min-age="{{ $package->min_age }}"
                                            data-max-age="{{ $package->max_age }}"
                                            data-age-range="{{ $package->age_range }}">
                                            {{ $package->name }} ({{ $package->type }}) - {{ $package->age_range }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row form-group">
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.date :id="'start_date'" :class="'form-control'" :name="'start_date'"
                            :isRequired="true" :requiredMessage="__('dashboard.start_date_is_required')" :label="__('dashboard.start_date')"
                            :value="old('start_date', $subscription->start_date ?? '')" />
                    </div>
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <div class="row">
                            <label class="col-4 col-form-label font-weight-bold" for="branch_id">{{ __('dashboard.branch') }}: </label>
                            <div class="col-8">
                                <select class="form-control" id="branch_id" name="branch_id">
                                    <option value="">{{ __('dashboard.select_branch') }}</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ (old('branch_id', $subscription->branch_id ?? '') == $branch->id) ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row form-group">
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.number :id="'price_paid'" :class="'form-control'" :name="'price_paid'"
                            :isRequired="true" :requiredMessage="__('dashboard.price_paid_is_required')" :label="__('dashboard.price_paid')"
                            :value="old('price_paid', $subscription->price_paid ?? '')" :step="0.01" :min="0" />
                    </div>
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <div class="row">
                            <label class="col-4 col-form-label font-weight-bold" for="payment_method">{{ __('dashboard.payment_method') }}: </label>
                            <div class="col-8">
                                <select class="form-control" id="payment_method" name="payment_method" required data-parsley-required-message="{{ __('dashboard.payment_method_is_required') }}">
                                    <option value="">{{ __('dashboard.select_payment_method') }}</option>
                                    <option value="visa" {{ (old('payment_method', $subscription->payment_method ?? '') == 'visa') ? 'selected' : '' }}>Visa</option>
                                    <option value="fawry" {{ (old('payment_method', $subscription->payment_method ?? '') == 'fawry') ? 'selected' : '' }}>Fawry</option>
                                    <option value="cash" {{ (old('payment_method', $subscription->payment_method ?? '') == 'cash') ? 'selected' : '' }}>Cash</option>
                                    <option value="transfer" {{ (old('payment_method', $subscription->payment_method ?? '') == 'transfer') ? 'selected' : '' }}>Transfer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($subscription))
                <div class="row form-group">
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <div class="row">
                            <label class="col-4 col-form-label font-weight-bold" for="status">{{ __('dashboard.status') }}: </label>
                            <div class="col-8">
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active" {{ (old('status', $subscription->status ?? '') == 'active') ? 'selected' : '' }}>{{ __('dashboard.active') }}</option>
                                    <option value="expired" {{ (old('status', $subscription->status ?? '') == 'expired') ? 'selected' : '' }}>{{ __('dashboard.expired') }}</option>
                                    <option value="cancelled" {{ (old('status', $subscription->status ?? '') == 'cancelled') ? 'selected' : '' }}>{{ __('dashboard.cancelled') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="row form-group">
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.file :id="'payment_document'" :class="'form-control'" :name="'payment_document'"
                            :isRequired="false" :label="__('dashboard.payment_document')" />
                        @if(isset($subscription) && $subscription->payment_document)
                            <small class="form-text text-muted">
                                <a href="{{ asset('storage/subscriptions/' . $subscription->payment_document) }}" target="_blank">
                                    {{ __('dashboard.view_current_document') }}
                                </a>
                            </small>
                        @endif
                    </div>
                    <div class="col-12 col-sm-12 offset-md-1 col-md-5 col-lg-4">
                        <x-dashboard.form.columns.textarea :id="'notes'" :class="'form-control'" :name="'notes'"
                            :isRequired="false" :label="__('dashboard.notes')" :rows="3"
                            :value="old('notes', $subscription->notes ?? '')" />
                    </div>
                </div>

                <!-- Price Preview -->
                <div id="price-preview" class="alert alert-info" style="display: none;">
                    <h6><i class="la la-info-circle"></i> {{ __('dashboard.price_preview') }}</h6>
                    <div id="price-details"></div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-10"></div>
                    <div class="col-2">
                        <button type="submit"
                            class="btn font-weight-bold btn-success mr-2  spinner-white spinner-right">{{ __('dashboard.save') }}</button>
                        <a href="{{ route('dashboard.subscriptions.index') }}"
                            class="btn font-weight-bold btn-secondary">{{ __('dashboard.cancel') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('javascript')
    <script src="{{ url(asset('public/metronic/assets/plugins/parsley/parsley.min.js')) }}"></script>
    <script src="{{ asset('js/form.js') }}"></script>
    <script>
        $(document).ready(function() {
                               function updatePricePreview() {
                       const playerSelect = $('#player_id');
                       const packageSelect = $('#package_id');
                       const pricePreview = $('#price-preview');
                       const priceDetails = $('#price-details');

                       if (playerSelect.val() && packageSelect.val()) {
                           const selectedPlayer = playerSelect.find('option:selected');
                           const selectedPackage = packageSelect.find('option:selected');
                           const nationality = selectedPlayer.data('nationality');
                           const priceEgyptian = selectedPackage.data('price-egyptian');
                           const priceOther = selectedPackage.data('price-other');
                           const minAge = selectedPackage.data('min-age');
                           const maxAge = selectedPackage.data('max-age');
                           const ageRange = selectedPackage.data('age-range');

                           const price = nationality === 'Egyptian' ? priceEgyptian : priceOther;

                           let eligibilityStatus = '';
                           let eligibilityClass = 'text-success';
                           
                           if (selectedPlayer.data('age')) {
                               const playerAge = selectedPlayer.data('age');
                               const isEligible = (!minAge || playerAge >= minAge) && (!maxAge || playerAge <= maxAge);
                               
                               if (isEligible) {
                                   eligibilityStatus = `<br><strong class="text-success">{{ __('dashboard.eligible_for_package') }}</strong>`;
                               } else {
                                   eligibilityStatus = `<br><strong class="text-danger">{{ __('dashboard.not_eligible_for_package') }}</strong>`;
                                   eligibilityClass = 'text-danger';
                               }
                           } else {
                               eligibilityStatus = `<br><strong class="text-warning">{{ __('dashboard.player_age_required') }}</strong>`;
                               eligibilityClass = 'text-warning';
                           }

                           priceDetails.html(`
                               <strong>${selectedPlayer.text()}</strong> (${nationality})<br>
                               <strong>${selectedPackage.text()}</strong><br>
                               <strong>{{ __('dashboard.age_range') }}: ${ageRange}</strong><br>
                               <strong>{{ __('dashboard.price') }}: $${price}</strong>${eligibilityStatus}
                           `);
                           pricePreview.removeClass('alert-info alert-warning alert-danger').addClass(`alert-${eligibilityClass === 'text-success' ? 'info' : eligibilityClass === 'text-danger' ? 'danger' : 'warning'}`);
                           pricePreview.show();
                       } else {
                           pricePreview.hide();
                       }
                   }
            
            $('#player_id, #package_id').on('change', updatePricePreview);
            updatePricePreview();
        });
    </script>
@endpush 