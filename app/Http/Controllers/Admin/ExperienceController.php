<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    /**
     * Affiche la liste des expériences.
     */
    public function index()
    {
        $experiences = Experience::orderBy('ordre', 'asc')->get();
        return view('admin.experiences.index', compact('experiences'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        return view('admin.experiences.create');
    }

    /**
     * Stocke une nouvelle expérience.
     */
    public function store(Request $request)
    {
        // On force is_active à true/false
        $request->merge([
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        // Validation
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'ordre' => 'nullable|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        // Définir l'ordre si non spécifié
        $validated['ordre'] = $validated['ordre'] ?? (Experience::max('ordre') + 1);

        Experience::create($validated);

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Expérience ajoutée avec succès !');
    }

    /**
     * Affiche le formulaire de modification.
     */
    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    /**
     * Met à jour une expérience existante.
     */
    public function update(Request $request, Experience $experience)
    {
        $request->merge([
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'ordre' => 'nullable|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        $experience->update($validated);

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Expérience modifiée avec succès !');
    }

    /**
     * Supprime une expérience.
     */
    public function destroy(Experience $experience)
    {
        $experience->delete();

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Expérience supprimée avec succès !');
    }

    /**
     * Met à jour l'ordre des expériences via drag & drop.
     */
    public function updateOrder(Request $request)
    {
        $order = $request->input('ordre', []);

        foreach ($order as $index => $id) {
            Experience::where('id', $id)->update(['ordre' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
