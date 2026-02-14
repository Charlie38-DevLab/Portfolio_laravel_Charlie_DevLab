<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $categories = SkillCategory::with('skills')
            ->ordered()
            ->get();

        $totalSkills = Skill::count();

        return view('admin.skills.index', compact('categories', 'totalSkills'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'skill_category_id' => 'required|exists:skill_categories,id',
            'level' => 'required|integer|min:0|max:100',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['order'] = $validated['order'] ?? Skill::where('skill_category_id', $validated['skill_category_id'])->max('order') + 1;

        Skill::create($validated);

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Compétence ajoutée avec succès !');
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:0|max:100',
        ]);

        $skill->update($validated);

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Compétence mise à jour avec succès !');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Compétence supprimée avec succès !');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'skills' => 'required|array',
            'skills.*.id' => 'required|exists:skills,id',
            'skills.*.order' => 'required|integer|min:0',
        ]);

        foreach ($validated['skills'] as $skillData) {
            Skill::where('id', $skillData['id'])->update(['order' => $skillData['order']]);
        }

        return response()->json(['success' => true]);
    }
}
// EOF
// cat SkillController.php
// Sortie

// <?php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\Skill;
// use App\Models\SkillCategory;
// use Illuminate\Http\Request;

// class SkillController extends Controller
// {
//     public function index()
//     {
//         $categories = SkillCategory::with('skills')
//             ->ordered()
//             ->get();

//         $totalSkills = Skill::count();

//         return view('admin.skills.index', compact('categories', 'totalSkills'));
//     }

//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'skill_category_id' => 'required|exists:skill_categories,id',
//             'level' => 'required|integer|min:0|max:100',
//             'order' => 'nullable|integer|min:0',
//         ]);

//         $validated['order'] = $validated['order'] ?? Skill::where('skill_category_id', $validated['skill_category_id'])->max('order') + 1;

//         Skill::create($validated);

//         return redirect()
//             ->route('admin.skills.index')
//             ->with('success', 'Compétence ajoutée avec succès !');
//     }

//     public function update(Request $request, Skill $skill)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'level' => 'required|integer|min:0|max:100',
//         ]);

//         $skill->update($validated);

//         return redirect()
//             ->route('admin.skills.index')
//             ->with('success', 'Compétence mise à jour avec succès !');
//     }

//     public function destroy(Skill $skill)
//     {
//         $skill->delete();

//         return redirect()
//             ->route('admin.skills.index')
//             ->with('success', 'Compétence supprimée avec succès !');
//     }

//     public function reorder(Request $request)
//     {
//         $validated = $request->validate([
//             'skills' => 'required|array',
//             'skills.*.id' => 'required|exists:skills,id',
//             'skills.*.order' => 'required|integer|min:0',
//         ]);

//         foreach ($validated['skills'] as $skillData) {
//             Skill::where('id', $skillData['id'])->update(['order' => $skillData['order']]);
//         }

//         return response()->json(['success' => true]);
//     }
// }
