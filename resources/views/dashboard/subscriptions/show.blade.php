@extends('dashboard.layouts.app')

@section('title', __('dashboard.subscription') . ' - ' . __('dashboard.view_subscription'))

@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => __('dashboard.view_subscription'),
        'short_description' => __('dashboard.subscription_details'),
        'breadcrumbs' => [],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ __('dashboard.subscription_details') }}
                    <i class="mr-2"></i>
                    <small class=""></small>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('dashboard.subscriptions.edit', ['subscription' => $subscription]) }}" class="btn btn-primary">
                    <i class="la la-edit"></i> {{ __('dashboard.edit') }}
                </a>
                <a href="{{ route('dashboard.subscriptions.index') }}" class="btn btn-secondary ml-2">
                    <i class="la la-arrow-left"></i> {{ __('dashboard.back') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="font-weight-bold text-primary mb-4">{{ __('dashboard.player_information') }}</h5>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.name') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $subscription->player->name }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.phone') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $subscription->player->phone }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.age') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $subscription->player->age }} {{ __('dashboard.years') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.nationality') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $subscription->player->nationality }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.gender') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ ucfirst($subscription->player->gender) }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h5 class="font-weight-bold text-primary mb-4">{{ __('dashboard.package_information') }}</h5>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.name') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $subscription->package->name }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.type') }}:</label>
                        <div class="col-8">
                            <span class="badge badge-{{ $subscription->package->type == 'Team' ? 'primary' : ($subscription->package->type == 'Academy' ? 'success' : 'warning') }}">
                                {{ $subscription->package->type }}
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.sessions_per_week') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $subscription->package->sessions_per_week }} {{ __('dashboard.sessions') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.age_range') }}:</label>
                        <div class="col-8">
                            <span class="badge badge-info">{{ $subscription->package->age_range }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.price_for_nationality') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">${{ number_format($subscription->package->getPriceForNationality($subscription->player->nationality), 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-5">

            <div class="row">
                <div class="col-md-6">
                    <h5 class="font-weight-bold text-primary mb-4">{{ __('dashboard.subscription_details') }}</h5>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.start_date') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $subscription->start_date->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.end_date') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $subscription->end_date->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.duration') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $subscription->duration_in_days }} {{ __('dashboard.days') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.days_remaining') }}:</label>
                        <div class="col-8">
                            @if($subscription->status === 'active')
                                <span class="badge badge-{{ $subscription->days_remaining <= 7 ? 'danger' : ($subscription->days_remaining <= 15 ? 'warning' : 'info') }}">
                                    {{ $subscription->days_remaining }} {{ __('dashboard.days') }}
                                </span>
                            @else
                                <span class="form-control-plaintext">-</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h5 class="font-weight-bold text-primary mb-4">{{ __('dashboard.payment_information') }}</h5>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.price_paid') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">${{ number_format($subscription->price_paid, 2) }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.payment_method') }}:</label>
                        <div class="col-8">
                            <span class="badge badge-{{ $subscription->payment_method == 'visa' ? 'primary' : ($subscription->payment_method == 'fawry' ? 'success' : ($subscription->payment_method == 'cash' ? 'warning' : 'info')) }}">
                                {{ ucfirst($subscription->payment_method) }}
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.status') }}:</label>
                        <div class="col-8">
                            <span class="badge badge-{{ $subscription->status == 'active' ? 'success' : ($subscription->status == 'expired' ? 'warning' : 'danger') }}">
                                {{ ucfirst($subscription->status) }}
                            </span>
                        </div>
                    </div>
                    @if($subscription->payment_document)
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.payment_document') }}:</label>
                        <div class="col-8">
                            <a href="{{ asset('storage/subscriptions/' . $subscription->payment_document) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="la la-download"></i> {{ __('dashboard.view_document') }}
                            </a>
                        </div>
                    </div>
                    @endif
                    @if($subscription->branch)
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.branch') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $subscription->branch->name }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if($subscription->notes)
            <hr class="my-5">
            <div class="row">
                <div class="col-12">
                    <h5 class="font-weight-bold text-primary mb-4">{{ __('dashboard.notes') }}</h5>
                    <div class="alert alert-info">
                        {{ $subscription->notes }}
                    </div>
                </div>
            </div>
            @endif

            <hr class="my-5">

            <div class="row">
                <div class="col-12">
                    <h5 class="font-weight-bold text-primary mb-4">{{ __('dashboard.quick_actions') }}</h5>
                    <a href="{{ route('dashboard.reservations.create', ['player_id' => $subscription->player_id, 'package_id' => $subscription->package_id]) }}" class="btn btn-success mr-2">
                        <i class="la la-calendar-plus"></i> {{ __('dashboard.make_reservation') }}
                    </a>
                    <a href="{{ route('dashboard.players.show', ['player' => $subscription->player]) }}" class="btn btn-info mr-2">
                        <i class="la la-user"></i> {{ __('dashboard.view_player') }}
                    </a>
                    <a href="{{ route('dashboard.packages.edit', ['package' => $subscription->package]) }}" class="btn btn-warning">
                        <i class="la la-cog"></i> {{ __('dashboard.view_package') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection 