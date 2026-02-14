<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminEventController extends Controller
{
    public function index()
    {
        $events = Event::latest('event_date')->paginate(15);

        $stats = [
            'total' => Event::count(),
            'upcoming' => Event::where('event_date', '>', now())->count(),
            'completed' => Event::where('event_date', '<', now())->count(),
            'total_registrations' => Event::sum('registered_count'),
        ];

        return view('admin.events.index', compact('events', 'stats'));
    }

    public function create()
    {
        return view('admin.events.form');
    }

    public function store(Request $request)
    {
        // ✅ Validation (PAS boolean pour les checkbox)
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:webinaire,masterclass,conference,formation,atelier',
            'event_date' => 'required|date|after:now',
            'duration' => 'required|string',
            'location' => 'required|string',
            'max_participants' => 'nullable|integer|min:1',

            'price' => 'nullable|numeric|min:0',
            'features' => 'nullable|string',
            'image' => 'required|string',

            // checkbox → pas de boolean ici
            'is_free' => 'sometimes',
            'is_featured' => 'nullable',
        ]);

        // Slug
        $data['slug'] = Str::slug($data['title']);

        // ✅ Conversion checkbox → vrai booléen
        $data['is_free'] = $request->has('is_free');
        $data['is_featured'] = $request->boolean('is_featured', false);

        // ✅ LOGIQUE MÉTIER
        if ($data['is_free']) {
            // Gratuit → prix forcé à 0
            $data['price'] = 0;
        } else {
            // Payant → prix obligatoire
            if (!$request->filled('price') || $request->price <= 0) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'price' => 'Le prix est obligatoire pour un événement payant.'
                    ]);
            }
        }

        Event::create($data);

        return redirect()->route('admin.events.index')
            ->with('success', 'Événement créé avec succès !');
    }

    public function edit(Event $event)
    {
        return view('admin.events.form', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:webinaire,masterclass,conference,formation,atelier',
            'event_date' => 'required|date',
            'duration' => 'required|string',
            'location' => 'required|string',
            'max_participants' => 'nullable|integer|min:1',

            'price' => 'nullable|numeric|min:0',
            'features' => 'nullable|string',
            'image' => 'required|string',

            // checkbox → pas boolean
            'is_free' => 'sometimes',
            'is_featured' => 'nullable',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['is_free'] = $request->has('is_free');
        $data['is_featured'] = $request->boolean('is_featured', false);

        if ($data['is_free']) {
            $data['price'] = 0;
        } else {
            if (!$request->filled('price') || $request->price <= 0) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'price' => 'Le prix est obligatoire pour un événement payant.'
                    ]);
            }
        }

        $event->update($data);

        return redirect()->route('admin.events.index')
            ->with('success', 'Événement mis à jour avec succès !');
    }

    public function destroy(Event $event)
    {
        if ($event->registrations()->count() > 0) {
            return back()->with(
                'error',
                'Impossible de supprimer un événement avec des inscriptions.'
            );
        }

        $event->delete();

        return back()->with('success', 'Événement supprimé avec succès.');
    }

    public function registrations(Event $event)
    {
        $registrations = $event->registrations()
            ->with('user')
            ->latest()
            ->get();

        return view('admin.events.registrations', compact('event', 'registrations'));
    }

    public function toggleStatus(Event $event)
    {
        $event->update([
            'is_featured' => !$event->is_featured
        ]);

        return back()->with('success', 'Statut mis à jour.');
    }
}
