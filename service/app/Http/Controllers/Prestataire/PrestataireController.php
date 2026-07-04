<?php

namespace App\Http\Controllers\Prestataire;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Schedule;
use Illuminate\Http\Request; 

class PrestataireController extends Controller
{
    public function index()
    {
        $stats = [
            'total_services'  => auth()->user()->services()->count(),
            'rdv_pending'     => auth()->user()->appointmentsAsPrestataire()->where('status', 'pending')->count(),
            'rdv_today'       => auth()->user()->appointmentsAsPrestataire()->whereDate('appointment_date', today())->count(),
            'rdv_confirmed'   => auth()->user()->appointmentsAsPrestataire()->where('status', 'confirmed')->count(),
        ];

        $appointments = auth()->user()->appointmentsAsPrestataire()
            ->with(['client', 'service'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('prestataire.dashboard', compact('stats', 'appointments'));
    }

    public function agenda()
    {
        $schedules = auth()->user()->schedules()->get()->keyBy('day');
        $days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        return view('prestataire.agenda', compact('schedules', 'days'));
    }

    public function saveAgenda(Request $request)
    {
        $days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];

        foreach ($days as $day) {
            if ($request->has("days.$day")) {
                Schedule::updateOrCreate(
                    ['user_id' => auth()->id(), 'day' => $day],
                    [
                        'start_time'   => $request->input("start.$day", '09:00'),
                        'end_time'     => $request->input("end.$day", '18:00'),
                        'is_available' => true,
                    ]
                );
            } else {
                Schedule::where('user_id', auth()->id())
                    ->where('day', $day)
                    ->update(['is_available' => false]);
            }
        }

        return back()->with('success', 'Agenda mis à jour!');
    }

    public function confirmRdv(Appointment $appointment)
    {
        $appointment->update(['status' => 'confirmed']);
        return back()->with('success', 'RDV confirmé!');
    }

    public function cancelRdv(Appointment $appointment)
    {
        $appointment->update(['status', 'cancelled']);
        return back()->with('success', 'RDV annulé.');
    }

    public function services()
    {
        return app(ServiceController::class)->index();
    }
}