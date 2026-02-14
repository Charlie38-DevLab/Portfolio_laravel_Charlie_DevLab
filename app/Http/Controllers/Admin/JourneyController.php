<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journey;
use Illuminate\Http\Request;

class JourneyController extends Controller
{
    public function index()
    {
        $journeys = Journey::ordered()->get();
        return view('admin.journeys.index', compact('journeys'));
    }

    public function create()
    {
        return view('admin.journeys.create');
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'year' => 'required|string|max:255',
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'order' => 'nullable|integer',
    //         'is_active' => 'boolean',
    //     ]);

    //     $validated['is_active'] = $request->has('is_active');
    //     $validated['order'] = $validated['order'] ?? Journey::max('order') + 1;

    //     Journey::create($validated);

    //     return redirect()->route('admin.journeys.index')
    //         ->with('success', 'Parcours ajouté avec succès !');
    // }


    public function store(Request $request)
    {
        // Transformer checkbox en boolean
        $request->merge([
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        // Validation
        $validated = $request->validate([
            'year' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|in:education,experience,project',
            'order' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'required|boolean', // maintenant c'est bien un boolean
        ]);

        // Création
        Journey::create($validated);

        return redirect()->route('admin.journeys.index')
                        ->with('success', 'Parcours créé avec succès !');
    }

    public function edit(Journey $journey)
    {
        return view('admin.journeys.edit', compact('journey'));
    }

    // public function update(Request $request, Journey $journey)
    // {
    //     $validated = $request->validate([
    //         'year' => 'required|string|max:255',
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'order' => 'nullable|integer',
    //         'is_active' => 'boolean',
    //     ]);

    //     $validated['is_active'] = $request->has('is_active');

    //     $journey->update($validated);

    //     return redirect()->route('admin.journeys.index')
    //         ->with('success', 'Parcours modifié avec succès !');
    // }

    public function update(Request $request, Journey $journey)
    {
        // Si la checkbox est décochée, elle n'est pas envoyée → on la transforme en false
        $request->merge([
            'is_active' => $request->has('is_active') ? true : false
        ]);

        $validated = $request->validate([
            'year' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'nullable|integer',
            'is_active' => 'required|boolean', // Maintenant toujours présent grâce à merge()
        ]);

        $journey->update($validated);

        return redirect()->route('admin.journeys.index')
            ->with('success', 'Parcours modifié avec succès !');
    }

    public function destroy(Journey $journey)
    {
        $journey->delete();

        return redirect()->route('admin.journeys.index')
            ->with('success', 'Parcours supprimé avec succès !');
    }

    public function updateOrder(Request $request)
    {
        $order = $request->input('order', []);

        foreach ($order as $index => $id) {
            Journey::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
