@extends('layouts.app')
@section('title', 'Dashboard Prestataire')

@section('content')

<div class="cards-grid">
    <div class="card purple">
        <div class="card-icon">✂️</div>
        <div class="card-label">Mes Services</div>
        <div class="card-value">{{ $stats['total_services'] }}</div>
    </div>
    <div class="card orange">
        <div class="card-icon">⏳</div>
        <div class="card-label">RDV en attente</div>
        <div class="card-value">{{ $stats['rdv_pending'] }}</div>
    </div>
    <div class="card green">
        <div class="card-icon">✅</div>
        <div class="card-label">RDV confirmés</div>
        <div class="card-value">{{ $stats['rdv_confirmed'] }}</div>
    </div>
    <div class="card red">
        <div class="card-icon">📅</div>
        <div class="card-label">RDV aujourd'hui</div>
        <div class="card-value">{{ $stats['rdv_today'] }}</div>
    </div>
</div>

<!-- RDV en attente -->
<div class="table-card">
    <div class="table-header">
        <h2>RDV en attente de confirmation</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Client</th>
                <th>Service</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $rdv)
            <tr>
                <td><strong>{{ $rdv->client->name }}</strong></td>
                <td>{{ $rdv->service->name }}</td>
                <td>{{ $rdv->appointment_date->format('d/m/Y H:i') }}</td>
                <td style="display:flex; gap:8px;">
                    <form method="POST" action="{{ route('prestataire.appointments.confirm', $rdv) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-success">✅ Confirmer</button>
                    </form>
                    <form method="POST" action="{{ route('prestataire.appointments.cancel', $rdv) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-danger">❌ Annuler</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <h3>Aucun RDV en attente</h3>
                        <p>Les nouveaux RDV apparaîtront ici</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection