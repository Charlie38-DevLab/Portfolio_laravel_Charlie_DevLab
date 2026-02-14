@extends('layouts.admin')

@section('title', 'Messages de Contact')

@section('content')
<div class="admin-header">
    <h1>Messages de Contact</h1>
    <p>Gérer les messages reçus via le formulaire de contact</p>
</div>

<div class="card">
    <div class="table-responsive">
        @if($contacts->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Statut</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Sujet</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td>
                                @if($contact->status === 'new')
                                    <span class="badge badge-new">🆕 Nouveau</span>
                                @elseif($contact->status === 'read')
                                    <span class="badge badge-read">👁️ Lu</span>
                                @else
                                    <span class="badge badge-replied">✅ Répondu</span>
                                @endif
                            </td>
                            <td>
                                <strong style="color: var(--text-primary);">{{ $contact->name }}</strong>
                            </td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ Str::limit($contact->subject, 40) }}</td>
                            <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.contacts.show', $contact->id) }}"
                                       class="action-btn"
                                       title="Voir">
                                        👁️
                                    </a>

                                    @if($contact->status === 'new')
                                        <form action="{{ route('admin.contacts.mark-read', $contact->id) }}"
                                              method="POST"
                                              style="display: inline;">
                                            @csrf
                                            <button type="submit" class="action-btn" title="Marquer comme lu">
                                                ✓
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}"
                                          method="POST"
                                          style="display: inline;"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Supprimer">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                {{ $contacts->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: var(--text-secondary);">
                <div style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.5;">📭</div>
                <p>Aucun message de contact</p>
            </div>
        @endif
    </div>
</div>
@endsection
