@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')

<div class="cards-grid">
    <div class="card purple">
        <div class="card-icon">👥</div>
        <div class="card-label">Total Clients</div>
        <div class="card-value">{{ $stats['total_clients'] }}</div>
    </div>
    <div class="card green">
        <div class="card-icon">👨‍💼</div>
        <div class="card-label">Prestataires actifs</div>
        <div class="card-value">{{ $stats['total_prestataires'] }}</div>
    </div>
    <div class="card orange">
        <div class="card-icon">📅</div>
        <div class="card-label">RDV aujourd'hui</div>
        <div class="card-value">{{ $stats['rdv_today'] }}</div>
    </div>
    <div class="card red">
        <div class="card-icon">⏳</div>
        <div class="card-label">En attente</div>
        <div class="card-value">{{ $stats['rdv_pending'] }}</div>
    </div>
</div>

<!-- Derniers RDV -->
<div class="table-card">
    <div class="table-header">
        <h2>Derniers Rendez-vous</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Client</th>
                <th>Prestataire</th>
                <th>Service</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recent_appointments as $rdv)
            <tr>
                <td>{{ $rdv->client->name }}</td>
                <td>{{ $rdv->prestataire->name }}</td>
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
                    <span class="badge {{ $badges[$rdv->status] }}">
                        {{ ucfirst($rdv->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <h3>Aucun rendez-vous</h3>
                        <p>Les RDV apparaîtront ici</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection