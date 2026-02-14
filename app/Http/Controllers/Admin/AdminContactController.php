<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    /**
     * Afficher la liste des messages
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(20);

        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Afficher un message
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        // Marquer comme lu si c'est nouveau
        if ($contact->isNew()) {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Supprimer un message
     */
    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();

            return redirect()
                ->route('admin.contacts.index')
                ->with('success', 'Message supprimé avec succès.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.contacts.index')
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    /**
     * Marquer un message comme lu
     */
    public function markAsRead($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->markAsRead();

            return redirect()
                ->back()
                ->with('success', 'Message marqué comme lu.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue.');
        }
    }

    /**
     * Marquer un message comme répondu
     */
    public function markAsReplied($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->markAsReplied();

            return redirect()
                ->back()
                ->with('success', 'Message marqué comme répondu.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue.');
        }
    }
}
