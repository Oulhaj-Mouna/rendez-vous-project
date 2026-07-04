@extends('layouts.app')
@section('title', 'Mes Services')

@section('content')

@if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif

<!-- Formulaire ajouter service -->
<div class="table-card" style="margin-bottom:24px; padding:24px;">
    <h2 style="font-size:16px; font-weight:700; margin-bottom:20px;">➕ Ajouter un service</h2>
    <form method="POST" action="{{ route('prestataire.services.store') }}">
        @csrf
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div>
                <label class="form-label">Nom du service</label>
                <input type="text" name="name" class="form-input" placeholder="Ex: Coupe homme" required>
            </div>
            <div>
                <label class="form-label">Catégorie</label>
                <select name="category" class="form-input" required>
                    <option value="">-- Choisir --</option>
                    <option value="coiffeur">Coiffeur</option>
                    <option value="dentiste">Dentiste</option>
                    <option value="coach">Coach</option>
                    <option value="medecin">Médecin</option>
                    <option value="autre">Autre</option>
                </select>
            </div>
            <div>
                <label class="form-label">Prix (MAD)</label>
                <input type="number" name="price" class="form-input" placeholder="150" min="0" required>
            </div>
            <div>
                <label class="form-label">Durée (minutes)</label>
                <input type="number" name="duration" class="form-input" placeholder="30" min="15" required>
            </div>
            <div style="grid-column:span 2;">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-input" rows="2" placeholder="Description du service..."></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:16px;">
            ➕ Ajouter le service
        </button>
    </form>
</div>

<!-- Liste services -->
<div class="table-card">
    <div class="table-header">
        <h2>Mes Services ({{ $services->count() }})</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Durée</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td>
                    <strong>{{ $service->name }}</strong>
                    @if($service->description)
                        <br><small style="color:#999;">{{ $service->description }}</small>
                    @endif
                </td>
                <td><span class="badge badge-purple">{{ $service->category }}</span></td>
                <td><strong>{{ $service->price }} MAD</strong></td>
                <td>{{ $service->duration }} min</td>
                <td>
                    @if($service->is_active)
                        <span class="badge badge-green">Actif</span>
                    @else
                        <span class="badge badge-orange">Inactif</span>
                    @endif
                </td>
                <td style="display:flex; gap:8px;">
                    <form method="POST" action="{{ route('prestataire.services.toggle', $service) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-primary" style="font-size:11px; padding:6px 12px;">
                            {{ $service->is_active ? '⏸ Désactiver' : '▶ Activer' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('prestataire.services.destroy', $service) }}"
                          onsubmit="return confirm('Supprimer ce service?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger" style="font-size:11px; padding:6px 12px;">🗑</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <div class="empty-icon">✂️</div>
                        <h3>Aucun service configuré</h3>
                        <p>Ajoutez votre premier service ci-dessus</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection