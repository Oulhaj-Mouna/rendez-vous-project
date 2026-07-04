@extends('layouts.app')
@section('title', 'Mes Rendez-vous')

@section('content')

<div class="table-card">
    <div class="table-header">
        <h2>Tous mes Rendez-vous</h2>
        <a href="{{ route('client.search') }}" class="btn btn-primary">➕ Nouveau RDV</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Prestataire</th>
                <th>Service</th>
                <th>Date</th>
                <th>Prix</th>
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
                <td>{{ $rdv->service->price }} MAD</td>
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
                    @else
                        <span style="color:#ccc; font-size:12px;">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <h3>Aucun rendez-vous</h3>
                        <p>Prenez votre premier RDV!</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection