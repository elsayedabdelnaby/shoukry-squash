@extends('dashboard.layouts.app')
@section('title', __('dashboard.players'))
@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => __('dashboard.players'),
        'short_description' => __('dashboard.manage_players'),
        'breadcrumbs' => [],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ __('dashboard.players') }}
                    <i class="mr-2"></i>
                    <small class=""></small>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('dashboard.players.create') }}" class="btn btn-primary font-weight-bolder">
                    <i class="flaticon2-plus-1"></i>
                    {{ __('dashboard.new_player') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('dashboard.id') }}</th>
                            <th>{{ __('dashboard.name') }}</th>
                            <th>{{ __('dashboard.phone') }}</th>
                            <th>{{ __('dashboard.birth_date') }}</th>
                            <th>{{ __('dashboard.age') }}</th>
                            <th>{{ __('dashboard.nationality') }}</th>
                            <th>{{ __('dashboard.gender') }}</th>
                            <th>{{ __('dashboard.parents_contact_number') }}</th>
                            <th>{{ __('dashboard.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($players as $player)
                            <tr>
                                <td>{{ $player->id }}</td>
                                <td>{{ $player->name }}</td>
                                <td>{{ $player->phone }}</td>
                                <td>{{ $player->birth_date ? \Carbon\Carbon::parse($player->birth_date)->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if($player->age)
                                        <span class="badge badge-info">{{ $player->age }} {{ __('dashboard.years') }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $player->nationality == 'Egyptian' ? 'success' : 'warning' }}">
                                        {{ $player->nationality }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $player->gender == 'male' ? 'primary' : 'pink' }}">
                                        {{ ucfirst($player->gender) }}
                                    </span>
                                </td>
                                <td>{{ $player->parents_contact_number ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('dashboard.players.show', ['player' => $player]) }}"
                                        class="btn btn-sm btn-clean btn-icon" title="{{ __('dashboard.view') }}">
                                        <i class="la la-eye"></i>
                                    </a>
                                    <a href="{{ route('dashboard.players.edit', ['player' => $player]) }}"
                                        class="btn btn-sm btn-clean btn-icon" title="{{ __('dashboard.edit') }}">
                                        <i class="la la-edit"></i>
                                    </a>
                                    <form action="{{ route('dashboard.players.destroy', ['player' => $player]) }}" method="post"
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
                                <td colspan="9" class="text-center py-5">
                                    <i class="la la-users font-size-h1 text-muted"></i>
                                    <h4 class="text-muted mt-3">{{ __('dashboard.no_players') }}</h4>
                                    <p class="text-muted">{{ __('dashboard.add_first_player') }}</p>
                                    <a href="{{ route('dashboard.players.create') }}" class="btn btn-primary">
                                        <i class="flaticon2-plus-1"></i>
                                        {{ __('dashboard.add_first_player') }}
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($players->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $players->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection 