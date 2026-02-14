<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkillCategory;
use Illuminate\Http\Request;

class SkillCategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:50',
            'color' => 'required|string|max:50',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['order'] = $validated['order'] ?? SkillCategory::max('order') + 1;

        SkillCategory::create($validated);

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Catégorie ajoutée avec succès !');
    }

    public function update(Request $request, SkillCategory $skillCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:50',
            'color' => 'required|string|max:50',
        ]);

        $skillCategory->update($validated);

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Catégorie mise à jour avec succès !');
    }

    public function destroy(SkillCategory $skillCategory)
    {
        // Vérifier s'il y a des compétences dans cette catégorie
        if ($skillCategory->skills()->count() > 0) {
            return redirect()
                ->route('admin.skills.index')
                ->with('error', 'Impossible de supprimer une catégorie contenant des compétences.');
        }

        $skillCategory->delete();

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Catégorie supprimée avec succès !');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:skill_categories,id',
            'categories.*.order' => 'required|integer|min:0',
        ]);

        foreach ($validated['categories'] as $categoryData) {
            SkillCategory::where('id', $categoryData['id'])->update(['order' => $categoryData['order']]);
        }

        return response()->json(['success' => true]);
    }
}
// EOF
// cat SkillCategoryController.php
// Sortie

// <?php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\SkillCategory;
// use Illuminate\Http\Request;

// class SkillCategoryController extends Controller
// {
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'icon' => 'required|string|max:50',
//             'color' => 'required|string|max:50',
//             'order' => 'nullable|integer|min:0',
//         ]);

//         $validated['order'] = $validated['order'] ?? SkillCategory::max('order') + 1;

//         SkillCategory::create($validated);

//         return redirect()
//             ->route('admin.skills.index')
//             ->with('success', 'Catégorie ajoutée avec succès !');
//     }

//     public function update(Request $request, SkillCategory $skillCategory)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'icon' => 'required|string|max:50',
//             'color' => 'required|string|max:50',
//         ]);

//         $skillCategory->update($validated);

//         return redirect()
//             ->route('admin.skills.index')
//             ->with('success', 'Catégorie mise à jour avec succès !');
//     }

//     public function destroy(SkillCategory $skillCategory)
//     {
//         // Vérifier s'il y a des compétences dans cette catégorie
//         if ($skillCategory->skills()->count() > 0) {
//             return redirect()
//                 ->route('admin.skills.index')
//                 ->with('error', 'Impossible de supprimer une catégorie contenant des compétences.');
//         }

//         $skillCategory->delete();

//         return redirect()
//             ->route('admin.skills.index')
//             ->with('success', 'Catégorie supprimée avec succès !');
//     }

//     public function reorder(Request $request)
//     {
//         $validated = $request->validate([
//             'categories' => 'required|array',
//             'categories.*.id' => 'required|exists:skill_categories,id',
//             'categories.*.order' => 'required|integer|min:0',
//         ]);

//         foreach ($validated['categories'] as $categoryData) {
//             SkillCategory::where('id', $categoryData['id'])->update(['order' => $categoryData['order']]);
//         }

//         return response()->json(['success' => true]);
//     }
// }
