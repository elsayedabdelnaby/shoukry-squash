@extends('dashboard.layouts.app')
@section('title', __('dashboard.subscriptions'))
@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => __('dashboard.subscriptions'),
        'short_description' => __('dashboard.manage_subscriptions'),
        'breadcrumbs' => [],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ __('dashboard.subscriptions') }}
                    <i class="mr-2"></i>
                    <small class=""></small>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('dashboard.subscriptions.create') }}" class="btn btn-primary font-weight-bolder">
                    <i class="flaticon2-plus-1"></i>
                    {{ __('dashboard.new_subscription') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <select class="form-control" id="status-filter">
                        <option value="">{{ __('dashboard.all_statuses') }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('dashboard.active') }}</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>{{ __('dashboard.expired') }}</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('dashboard.cancelled') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="player-filter">
                        <option value="">{{ __('dashboard.all_players') }}</option>
                        @foreach($players as $player)
                            <option value="{{ $player->id }}" {{ request('player_id') == $player->id ? 'selected' : '' }}>
                                {{ $player->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="package-filter">
                        <option value="">{{ __('dashboard.all_packages') }}</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" {{ request('package_id') == $package->id ? 'selected' : '' }}>
                                {{ $package->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-secondary" onclick="applyFilters()">
                        <i class="la la-filter"></i> {{ __('dashboard.filter') }}
                    </button>
                    <a href="{{ route('dashboard.subscriptions.index') }}" class="btn btn-light ml-2">
                        <i class="la la-refresh"></i> {{ __('dashboard.clear') }}
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('dashboard.id') }}</th>
                            <th>{{ __('dashboard.player') }}</th>
                            <th>{{ __('dashboard.package') }}</th>
                            <th>{{ __('dashboard.branch') }}</th>
                            <th>{{ __('dashboard.start_date') }}</th>
                            <th>{{ __('dashboard.end_date') }}</th>
                            <th>{{ __('dashboard.price_paid') }}</th>
                            <th>{{ __('dashboard.payment_method') }}</th>
                            <th>{{ __('dashboard.status') }}</th>
                            <th>{{ __('dashboard.days_remaining') }}</th>
                            <th>{{ __('dashboard.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->id }}</td>
                                <td>
                                    <a href="{{ route('dashboard.players.show', ['player' => $subscription->player]) }}">
                                        {{ $subscription->player->name }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $subscription->package->type == 'Team' ? 'primary' : ($subscription->package->type == 'Academy' ? 'success' : 'warning') }}">
                                        {{ $subscription->package->name }}
                                    </span>
                                </td>
                                <td>{{ $subscription->branch ? $subscription->branch->name : '-' }}</td>
                                <td>{{ $subscription->start_date->format('d/m/Y') }}</td>
                                <td>{{ $subscription->end_date->format('d/m/Y') }}</td>
                                <td>${{ number_format($subscription->price_paid, 2) }}</td>
                                <td>
                                    <span class="badge badge-info">{{ ucfirst($subscription->payment_method) }}</span>
                                </td>
                                <td>
                                    @if($subscription->status === 'active')
                                        <span class="badge badge-success">{{ __('dashboard.active') }}</span>
                                    @elseif($subscription->status === 'expired')
                                        <span class="badge badge-danger">{{ __('dashboard.expired') }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ __('dashboard.cancelled') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($subscription->status === 'active')
                                        <span class="badge badge-{{ $subscription->days_remaining <= 7 ? 'danger' : ($subscription->days_remaining <= 15 ? 'warning' : 'info') }}">
                                            {{ $subscription->days_remaining }} {{ __('dashboard.days') }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.subscriptions.show', ['subscription' => $subscription]) }}"
                                        class="btn btn-sm btn-clean btn-icon" title="{{ __('dashboard.view') }}">
                                        <i class="la la-eye"></i>
                                    </a>
                                    <a href="{{ route('dashboard.subscriptions.edit', ['subscription' => $subscription]) }}"
                                        class="btn btn-sm btn-clean btn-icon" title="{{ __('dashboard.edit') }}">
                                        <i class="la la-edit"></i>
                                    </a>
                                    <a href="{{ route('dashboard.reservations.create', ['player_id' => $subscription->player_id, 'package_id' => $subscription->package_id]) }}"
                                        class="btn btn-sm btn-clean btn-icon" title="{{ __('dashboard.make_reservation') }}">
                                        <i class="la la-calendar-plus"></i>
                                    </a>
                                    <form action="{{ route('dashboard.subscriptions.destroy', ['subscription' => $subscription]) }}" method="post"
                                        class="d-inline-block">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-clean btn-icon"
                                            title="{{ __('dashboard.delete') }}"
                                            onclick="return confirm('{{ __('dashboard.are_you_sure_delete') }}')">
                                            <i class="la la-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <i class="la la-credit-card font-size-h1 text-muted"></i>
                                    <h4 class="text-muted mt-3">{{ __('dashboard.no_subscriptions') }}</h4>
                                    <p class="text-muted">{{ __('dashboard.add_first_subscription') }}</p>
                                    <a href="{{ route('dashboard.subscriptions.create') }}" class="btn btn-primary">
                                        <i class="flaticon2-plus-1"></i>
                                        {{ __('dashboard.add_first_subscription') }}
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($subscriptions->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('javascript')
    <script>
        function applyFilters() {
            const status = document.getElementById('status-filter').value;
            const playerId = document.getElementById('player-filter').value;
            const packageId = document.getElementById('package-filter').value;
            
            let url = '{{ route("dashboard.subscriptions.index") }}?';
            const params = [];
            
            if (status) params.push('status=' + status);
            if (playerId) params.push('player_id=' + playerId);
            if (packageId) params.push('package_id=' + packageId);
            
            if (params.length > 0) {
                url += params.join('&');
            }
            
            window.location.href = url;
        }
    </script>
@endpush 