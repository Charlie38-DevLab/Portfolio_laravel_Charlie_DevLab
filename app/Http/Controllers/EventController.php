<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::upcoming();

        // Filtrer par type
        $selectedType = $request->get('type', 'all');
        if ($selectedType !== 'all') {
            $query->where('type', $selectedType);
        }

        // Filtrer par statut temporel
        $selectedStatus = $request->get('status', 'all');
        if ($selectedStatus === 'upcoming') {
            $query->where('event_date', '>', now());
        } elseif ($selectedStatus === 'live') {
            $query->where('event_date', '<=', now())
                  ->where('event_date', '>=', now()->subHours(3));
        } elseif ($selectedStatus === 'replay') {
            $query->where('event_date', '<', now()->subHours(3));
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $events = $query->orderBy('event_date')->get();

        return view('public.events.index', compact('events', 'selectedType', 'selectedStatus'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $isRegistered = false;
        if (Auth::check()) {
            $isRegistered = EventRegistration::where('event_id', $event->id)
                ->where('user_id', Auth::id())
                ->exists();
        }

        $relatedEvents = Event::where('type', $event->type)
            ->where('id', '!=', $event->id)
            ->upcoming()
            ->limit(3)
            ->get();

        return view('public.events.show', compact('event', 'isRegistered', 'relatedEvents'));
    }

    public function register(Request $request, $slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour vous inscrire.');
        }

        $event = Event::where('slug', $slug)->firstOrFail();

        if (!$event->hasAvailableSlots()) {
            return back()->with('error', 'Désolé, cet événement est complet.');
        }

        $existingRegistration = EventRegistration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingRegistration) {
            return back()->with('info', 'Vous êtes déjà inscrit à cet événement.');
        }

        EventRegistration::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'status' => 'confirmed',
        ]);

        $event->increment('registered_count');

        return back()->with('success', 'Votre inscription a été confirmée ! Vous recevrez un email de confirmation.');
    }

    public function cancelRegistration($slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $event = Event::where('slug', $slug)->firstOrFail();

        $registration = EventRegistration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$registration) {
            return back()->with('error', 'Vous n\'êtes pas inscrit à cet événement.');
        }

        $registration->delete();
        $event->decrement('registered_count');

        return back()->with('success', 'Votre inscription a été annulée.');
    }
}
