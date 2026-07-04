<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;

class ClientController extends Controller
{
    public function index()
    {
        $stats = [
            'rdv_pending'   => auth()->user()->appointmentsAsClient()->where('status', 'pending')->count(),
            'rdv_confirmed' => auth()->user()->appointmentsAsClient()->where('status', 'confirmed')->count(),
            'rdv_completed' => auth()->user()->appointmentsAsClient()->where('status', 'completed')->count(),
        ];

        $appointments = auth()->user()->appointmentsAsClient()
            ->with(['prestataire', 'service'])
            ->latest()
            ->take(5)
            ->get();

        return view('client.dashboard', compact('stats', 'appointments'));
    }

    public function appointments()
    {
        $appointments = auth()->user()->appointmentsAsClient()
            ->with(['prestataire', 'service'])
            ->latest()
            ->get();

        return view('client.appointments', compact('appointments'));
    }

    public function search()
    {
        $prestataires = User::where('role', 'prestataire')
            ->where('is_active', true)
            ->with('services')
            ->get();

        $categories = ['coiffeur', 'dentiste', 'coach', 'medecin', 'autre'];

        return view('client.search', compact('prestataires', 'categories'));
    }
}