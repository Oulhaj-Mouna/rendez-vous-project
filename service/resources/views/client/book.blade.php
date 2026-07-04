@extends('layouts.app')
@section('title', 'Prendre un RDV')

@section('content')

<div class="book-card">
    <div class="book-header">
        <div class="sidebar-avatar" style="width:56px; height:56px; font-size:22px; flex-shrink:0;">
            {{ strtoupper(substr($prestataire->name, 0, 1)) }}
        </div>
        <div>
            <div class="book-title">{{ $prestataire->name }}</div>
            <div class="book-sub">Choisissez un service et une date</div>
        </div>
    </div>

    <form method="POST" action="{{ route('client.book.store') }}">
        @csrf
        <input type="hidden" name="prestataire_id" value="{{ $prestataire->id }}">

        <div class="form-group">
            <label class="form-label">Service</label>
            <select name="service_id" class="form-input" required>
                <option value="">-- Choisir un service --</option>
                @foreach($services as $service)
                <option value="{{ $service->id }}">
                    {{ $service->name }} — {{ $service->price }} MAD ({{ $service->duration }} min)
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Date et heure</label>
            <input type="datetime-local"
                   name="appointment_date"
                   class="form-input"
                   min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                   required>
        </div>

        <div class="form-group">
            <label class="form-label">Notes (optionnel)</label>
            <textarea name="notes" class="form-input" rows="3"
                      placeholder="Informations supplémentaires..."></textarea>
        </div>

        <div class="form-actions">
            <a href="{{ route('client.search') }}" class="btn-back">← Retour</a>
            <button type="submit" class="btn btn-primary" style="flex:1;">
                📅 Confirmer le RDV
            </button>
        </div>
    </form>
</div>

@endsection