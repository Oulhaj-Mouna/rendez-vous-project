@extends('layouts.app')
@section('title', 'Chercher un prestataire')

@section('content')

<div class="filter-pills">
    <a href="{{ route('client.search') }}"
       class="pill {{ !request('category') ? 'active' : '' }}">
        🌟 Tous
    </a>
    @foreach($categories as $cat)
    <a href="{{ route('client.search', ['category' => $cat]) }}"
       class="pill {{ request('category') === $cat ? 'active' : '' }}">
        {{ ucfirst($cat) }}
    </a>
    @endforeach
</div>

<div class="prestataire-grid">
    @forelse($prestataires as $prestataire)
    <div class="prestataire-card">
        <div class="prestataire-card-header">
            <div class="sidebar-avatar" style="width:48px; height:48px; font-size:20px; flex-shrink:0;">
                {{ strtoupper(substr($prestataire->name, 0, 1)) }}
            </div>
            <div>
                <div class="prestataire-card-name">{{ $prestataire->name }}</div>
                <div class="prestataire-card-sub">{{ $prestataire->services->count() }} service(s) disponible(s)</div>
            </div>
        </div>

        <div style="margin-bottom:16px;">
            @foreach($prestataire->services->take(3) as $service)
            <div class="service-line">
                <span>{{ $service->name }}</span>
                <span class="service-price">{{ $service->price }} MAD</span>
            </div>
            @endforeach
        </div>

        <a href="{{ route('client.book', $prestataire) }}" class="btn btn-primary" style="width:100%; text-align:center; display:block;">
            📅 Prendre RDV
        </a>
    </div>
    @empty
    <div class="empty-state" style="grid-column:span 3;">
        <div class="empty-icon">👨‍💼</div>
        <h3>Aucun prestataire disponible</h3>
        <p>Revenez plus tard</p>
    </div>
    @endforelse
</div>

@endsection