@extends('layouts.app')
@section('title', 'Prestataires')

@section('content')
<div class="table-card">
    <div class="table-header">
        <h2>Liste des Prestataires</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Services</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prestataires as $prestataire)
            <tr>
                <td><strong>{{ $prestataire->name }}</strong></td>
                <td>{{ $prestataire->email }}</td>
                <td>{{ $prestataire->services->count() }} service(s)</td>
                <td>
                    @if($prestataire->is_active)
                        <span class="badge badge-green">Actif</span>
                    @else
                        <span class="badge badge-orange">En attente</span>
                    @endif
                </td>
                <td style="display:flex; gap:8px;">
                    @if(!$prestataire->is_active)
                    <form method="POST" action="{{ route('admin.prestataires.activate', $prestataire) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-success">✅ Valider</button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('admin.prestataires.suspend', $prestataire) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-danger">🚫 Suspendre</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <div class="empty-icon">👨‍💼</div>
                        <h3>Aucun prestataire</h3>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection