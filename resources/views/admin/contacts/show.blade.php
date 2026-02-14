@extends('layouts.admin')

@section('title', 'Message de ' . $contact->name)

@section('content')
<div class="admin-header">
    <h1>Message de Contact</h1>
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
        ← Retour à la liste
    </a>
</div>

<div style="max-width: 900px;">
    <div class="card">
        <!-- En-tête du message -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid var(--dark-border);">
            <div>
                @if($contact->status === 'new')
                    <span class="badge badge-new">🆕 Nouveau</span>
                @elseif($contact->status === 'read')
                    <span class="badge badge-read">👁️ Lu</span>
                @else
                    <span class="badge badge-replied">✅ Répondu</span>
                @endif
            </div>
            <div style="color: var(--text-secondary);">
                {{ $contact->created_at->format('d/m/Y à H:i') }}
            </div>
        </div>

        <!-- Informations expéditeur -->
        <div style="background: rgba(108, 92, 231, 0.05); padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                <div>
                    <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.3rem;">
                        Nom
                    </div>
                    <div style="font-weight: 600; font-size: 1.1rem;">
                        {{ $contact->name }}
                    </div>
                </div>
                <div>
                    <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.3rem;">
                        Email
                    </div>
                    <div style="font-weight: 600; font-size: 1.1rem;">
                        <a href="mailto:{{ $contact->email }}" style="color: var(--primary); text-decoration: none;">
                            {{ $contact->email }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sujet -->
        <div style="margin-bottom: 2rem;">
            <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem;">
                Sujet
            </div>
            <h2 style="font-size: 1.5rem; font-weight: 700;">
                {{ $contact->subject }}
            </h2>
        </div>

        <!-- Message -->
        <div style="margin-bottom: 2rem;">
            <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem;">
                Message
            </div>
            <div style="background: var(--dark-bg); padding: 1.5rem; border-radius: 10px; line-height: 1.8; white-space: pre-wrap;">
                {{ $contact->message }}
            </div>
        </div>

        <!-- Actions -->
        <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 2rem; border-top: 1px solid var(--dark-border);">
            <!-- Répondre par email -->
            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}"
               class="btn btn-primary">
                ✉️ Répondre par email
            </a>

            @if($contact->status !== 'replied')
                <!-- Marquer comme répondu -->
                <form action="{{ route('admin.contacts.mark-read', $contact->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        ✓ Marquer comme répondu
                    </button>
                </form>
            @endif

            <!-- Supprimer -->
            <form action="{{ route('admin.contacts.destroy', $contact->id) }}"
                  method="POST"
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    🗑️ Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
