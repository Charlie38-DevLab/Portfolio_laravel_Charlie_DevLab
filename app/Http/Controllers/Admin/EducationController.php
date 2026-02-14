<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::ordered()->get();
        return view('admin.educations.index', compact('educations'));
    }

    public function create()
    {
        return view('admin.educations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'degree' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:10',
            'ordre' => 'nullable|integer',
        ]);

        // ✅ Gestion manuelle de is_active pour éviter l'erreur
        $validated['is_active'] = $request->has('is_active');
        $validated['ordre'] = $validated['ordre'] ?? (Education::max('ordre') + 1);
        $validated['icon'] = $validated['icon'] ?? '🎓';

        Education::create($validated);

        return redirect()->route('admin.educations.index')
            ->with('success', 'Formation ajoutée avec succès !');
    }

    public function edit(Education $education)
    {
        return view('admin.educations.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $validated = $request->validate([
            'degree' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:10',
            'ordre' => 'nullable|integer',
        ]);

        // ✅ Gestion manuelle de is_active
        $validated['is_active'] = $request->has('is_active');

        $education->update($validated);

        return redirect()->route('admin.educations.index')
            ->with('success', 'Formation modifiée avec succès !');
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return redirect()->route('admin.educations.index')
            ->with('success', 'Formation supprimée avec succès !');
    }

    public function updateOrder(Request $request)
    {
        $ordre = $request->input('ordre', []);

        foreach ($ordre as $index => $id) {
            Education::where('id', $id)->update(['ordre' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
