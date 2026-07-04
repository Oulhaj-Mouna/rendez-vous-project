<?php

namespace App\Http\Controllers\Prestataire;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = auth()->user()->services()->latest()->get();
        return view('prestataire.services', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'duration'    => 'required|integer|min:15',
            'category'    => 'required|string',
        ]);

        auth()->user()->services()->create($request->all());

        return back()->with('success', 'Service ajouté avec succès!');
    }

    public function destroy(Service $service)
    {
        if ($service->user_id !== auth()->id()) {
            abort(403);
        }
        $service->delete();
        return back()->with('success', 'Service supprimé.');
    }

    public function toggleActive(Service $service)
    {
        if ($service->user_id !== auth()->id()) {
            abort(403);
        }
        $service->update(['is_active' => !$service->is_active]);
        return back()->with('success', 'Statut mis à jour.');
    }
}