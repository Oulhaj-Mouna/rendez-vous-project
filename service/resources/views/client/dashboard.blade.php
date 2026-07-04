@extends('layouts.app')
@section('title', 'Mon Espace')

@section('content')

<div class="cards-grid">
    <div class="card orange">
        <div class="card-icon">⏳</div>
        <div class="card-label">En attente</div>
        <div class="card-value">{{ $stats['rdv_pending'] }}</div>
    </div>
    <div class="card green">
        <div class="card-icon">✅</div>
        <div class="card-label">Confirmés</div>
        <div class="card-value">{{ $stats['rdv_confirmed'] }}</div>
    </div>
    <div class="card purple">
        <div class="card-icon">🎉</div>
        <div class="card-label">Terminés</div>
        <div class="card-value">{{ $stats['rdv_completed'] }}</div>
    </div>
</div>

<!-- Derniers RDV -->
<div class="table-card">
    <div class="table-header">
        <h2>Mes derniers RDV</h2>
        <a href="{{ route('client.search') }}" class="btn btn-primary">➕ Prendre un RDV</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Prestataire</th>
                <th>Service</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $rdv)
            <tr>
                <td><strong>{{ $rdv->prestataire->name }}</strong></td>
                <td>{{ $rdv->service->name }}</td>
                <td>{{ $rdv->appointment_date->format('d/m/Y H:i') }}</td>
                <td>
                    @php
                        $badges = [
                            'pending'   => 'badge-orange',
                            'confirmed' => 'badge-green',
                            'cancelled' => 'badge-red',
                            'completed' => 'badge-purple',
                        ];
                    @endphp
                    <span class="badge {{ $badges[$rdv->status] }}">{{ ucfirst($rdv->status) }}</span>
                </td>
                <td>
                    @if($rdv->status === 'pending')
                    <form method="POST" action="{{ route('client.appointments.cancel', $rdv) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-danger" style="font-size:11px; padding:6px 12px;">
                            ❌ Annuler
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <h3>Aucun RDV pour le moment</h3>
                        <p>Prenez votre premier rendez-vous!</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection