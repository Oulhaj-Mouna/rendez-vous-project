@extends('layouts.app')
@section('title', 'Mon Agenda')

@section('content')

@if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif

<div class="table-card" style="padding:24px;">
    <h2 style="font-size:16px; font-weight:700; margin-bottom:24px;">📅 Mes disponibilités</h2>

    <form method="POST" action="{{ route('prestataire.agenda.save') }}">
        @csrf
        <table>
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Disponible</th>
                    <th>Début</th>
                    <th>Fin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($days as $day)
                @php $schedule = $schedules->get($day); @endphp
                <tr>
                    <td><strong style="text-transform:capitalize;">{{ $day }}</strong></td>
                    <td>
                        <input type="checkbox"
                               name="days[{{ $day }}]"
                               value="1"
                               {{ $schedule && $schedule->is_available ? 'checked' : '' }}
                               style="width:18px; height:18px; cursor:pointer;">
                    </td>
                    <td>
                        <input type="time"
                               name="start[{{ $day }}]"
                               class="form-input"
                               value="{{ $schedule ? $schedule->start_time : '09:00' }}"
                               style="width:130px;">
                    </td>
                    <td>
                        <input type="time"
                               name="end[{{ $day }}]"
                               class="form-input"
                               value="{{ $schedule ? $schedule->end_time : '18:00' }}"
                               style="width:130px;">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary" style="margin-top:24px;">
            💾 Enregistrer l'agenda
        </button>
    </form>
</div>

@endsection