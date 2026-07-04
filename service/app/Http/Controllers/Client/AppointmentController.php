<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create(User $prestataire)
    {
        $services = $prestataire->services()->where('is_active', true)->get();
        $schedules = $prestataire->schedules()->where('is_available', true)->get();
        return view('client.book', compact('prestataire', 'services', 'schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prestataire_id'   => 'required|exists:users,id',
            'service_id'       => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:now',
        ]);

        Appointment::create([
            'client_id'        => auth()->id(),
            'prestataire_id'   => $request->prestataire_id,
            'service_id'       => $request->service_id,
            'appointment_date' => $request->appointment_date,
            'status'           => 'pending',
            'notes'            => $request->notes,
        ]);

        return redirect()->route('client.appointments')
            ->with('success', 'RDV réservé avec succès! En attente de confirmation.');
    }

    public function cancel(Appointment $appointment)
    {
        if ($appointment->client_id !== auth()->id()) {
            abort(403);
        }

        $appointment->update(['status' => 'cancelled']);
        return back()->with('success', 'RDV annulé.');
    }
}