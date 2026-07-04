<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Service;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_clients'      => User::where('role', 'client')->count(),
            'total_prestataires' => User::where('role', 'prestataire')->where('is_active', true)->count(),
            'rdv_today'          => Appointment::today()->count(),
            'rdv_pending'        => Appointment::pending()->count(),
        ];

        $recent_appointments = Appointment::with(['client', 'prestataire', 'service'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_appointments'));
    }

    public function users()
    {
        $users = User::where('role', 'client')->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function prestataires()
    {
        $prestataires = User::where('role', 'prestataire')->latest()->get();
        return view('admin.prestataires', compact('prestataires'));
    }

    public function activate(User $user)
    {
        $user->update(['is_active' => true]);
        return back()->with('success', 'Prestataire activé avec succès!');
    }

    public function suspend(User $user)
    {
        $user->update(['is_active' => false]);
        return back()->with('success', 'Prestataire suspendu.');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }
}