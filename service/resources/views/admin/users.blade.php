@extends('layouts.app')
@section('title', 'Clients')

@section('content')
<div class="table-card">
    <div class="table-header">
        <h2>Liste des Clients</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Inscrit le</th>
                <th>RDV</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>{{ $user->appointmentsAsClient->count() }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                          onsubmit="return confirm('Supprimer ce client?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger">🗑 Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <div class="empty-icon">👥</div>
                        <h3>Aucun client</h3>
                        <p>Les clients inscrits apparaîtront ici</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection