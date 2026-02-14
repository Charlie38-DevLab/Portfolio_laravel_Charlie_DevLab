<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Realisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminRealisationController extends Controller
{
    /**
     * Liste des réalisations
     */
    public function index()
    {
        $realisations = Realisation::latest()->paginate(15);
        return view('admin.realisations.index', compact('realisations'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        return view('admin.realisations.create');
    }

    /**
     * Enregistrer une nouvelle réalisation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'technologies' => 'required|string',
            'client' => 'nullable|string|max:255',
            'completion_date' => 'required|date',
            'project_url' => 'nullable|url',
        ]);

        try {
            // Image
            $imagePath = $request->file('image')->store('realisations', 'public');

            // Technologies en tableau
            $technologies = array_map(
                'trim',
                explode(',', $validated['technologies'])
            );

            Realisation::create([
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']) . '-' . uniqid(),
                'description' => $validated['description'],
                'category' => $validated['category'],
                'image' => $imagePath,
                'technologies' => $technologies,
                'client' => $validated['client'],
                'completion_date' => $validated['completion_date'],
                'project_url' => $validated['project_url'],
                'featured' => $request->has('featured'),
            ]);

            return redirect()
                ->route('admin.realisations.index')
                ->with('success', 'Réalisation créée avec succès ✅');

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création.');
        }
    }

    /**
     * Formulaire d’édition
     */
    public function edit(Realisation $realisation)
    {
        return view('admin.realisations.edit', compact('realisation'));
    }

    /**
     * Mise à jour d’une réalisation
     */
    public function update(Request $request, Realisation $realisation)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'technologies' => 'required|string',
            'client' => 'nullable|string|max:255',
            'completion_date' => 'required|date',
            'project_url' => 'nullable|url',
        ]);

        try {
            // Image (optionnelle)
            $imagePath = $realisation->image;

            if ($request->hasFile('image')) {
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $request->file('image')->store('realisations', 'public');
            }

            // Technologies
            $technologies = array_map(
                'trim',
                explode(',', $validated['technologies'])
            );

            $realisation->update([
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']) . '-' . $realisation->id,
                'description' => $validated['description'],
                'category' => $validated['category'],
                'image' => $imagePath,
                'technologies' => $technologies,
                'client' => $validated['client'],
                'completion_date' => $validated['completion_date'],
                'project_url' => $validated['project_url'],
                'featured' => $request->has('featured'),
            ]);

            return redirect()
                ->route('admin.realisations.edit', $realisation->id)
                ->with('success', 'Réalisation mise à jour avec succès ✅');

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour.');
        }
    }

    /**
     * Suppression d’une réalisation
     */
    public function destroy(Realisation $realisation)
    {
        try {
            if ($realisation->image && Storage::disk('public')->exists($realisation->image)) {
                Storage::disk('public')->delete($realisation->image);
            }

            $realisation->delete();

            return redirect()
                ->route('admin.realisations.index')
                ->with('success', 'Réalisation supprimée avec succès 🗑️');

        } catch (\Throwable $e) {
            return back()->with('error', 'Erreur lors de la suppression.');
        }
    }
}
