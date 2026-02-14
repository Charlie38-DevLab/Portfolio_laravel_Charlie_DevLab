@extends('layouts.admin')

@section('title', 'Gestion des Formations')

@section('content')
<div class="admin-educations-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestion des Formations</h1>
            <p class="page-subtitle">Gérez votre parcours académique et certifications</p>
        </div>
        <a href="{{ route('admin.educations.create') }}" class="btn btn-primary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Nouvelle formation
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-total">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Formations</p>
                <h3 class="stat-value">{{ $educations->count() }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-active">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Actives</p>
                <h3 class="stat-value">{{ $educations->where('is_active', true)->count() }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-inactive">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Inactives</p>
                <h3 class="stat-value">{{ $educations->where('is_active', false)->count() }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-diplomas">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Diplômes obtenus</p>
                <h3 class="stat-value">{{ $educations->count() }}</h3>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Educations List -->
    <div class="educations-container">
        <div class="container-header">
            <h2 class="container-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                </svg>
                Liste des formations
            </h2>
            <div class="container-actions">
                <span class="info-text">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M12 2v20M2 12h20"></path>
                    </svg>
                    Glissez-déposez pour réorganiser
                </span>
            </div>
        </div>

        @forelse($educations as $education)
            <div class="education-card" data-id="{{ $education->id }}">
                <div class="drag-handle">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="5" y1="9" x2="19" y2="9"></line>
                        <line x1="5" y1="15" x2="19" y2="15"></line>
                    </svg>
                </div>

                <div class="education-icon">
                    <span class="icon-emoji">{{ $education->icon ?? '🎓' }}</span>
                </div>

                <div class="education-content">
                    <div class="education-header">
                        <div class="header-left">
                            <h3 class="education-degree">{{ $education->degree }}</h3>
                            <span class="education-school">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                </svg>
                                {{ $education->school }}
                            </span>
                        </div>
                        <span class="status-badge {{ $education->is_active ? 'badge-active' : 'badge-inactive' }}">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                @if($education->is_active)
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                @else
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                @endif
                            </svg>
                            {{ $education->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <p class="education-description">{{ Str::limit($education->description, 150) }}</p>
                </div>

                <div class="education-actions">
                    <a href="{{ route('admin.educations.edit', $education) }}"
                       class="action-btn btn-edit"
                       title="Modifier">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </a>

                    <form action="{{ route('admin.educations.destroy', $education) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette formation ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn btn-delete" title="Supprimer">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                </svg>
                <h3>Aucune formation</h3>
                <p>Commencez par ajouter votre première formation académique</p>
                <a href="{{ route('admin.educations.create') }}" class="btn btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Ajouter une formation
                </a>
            </div>
        @endforelse
    </div>
</div>

<style>
:root {
    --primary: #6366f1;
    --secondary: #8b5cf6;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --dark-bg: #0f172a;
    --card-bg: #1e293b;
    --text-primary: #f1f5f9;
    --text-secondary: #94a3b8;
    --border: #334155;
}

.admin-educations-page {
    padding: 32px;
    background: var(--dark-bg);
    min-height: 100vh;
}

/* Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
}

.page-title {
    font-size: 32px;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.page-subtitle {
    font-size: 16px;
    color: var(--text-secondary);
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn svg {
    stroke-width: 2;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: var(--secondary);
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(99, 102, 241, 0.3);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 24px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.stat-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
}

.stat-icon svg {
    stroke-width: 2;
}

.stat-total {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
}

.stat-active {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.stat-inactive {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.stat-diplomas {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.stat-label {
    font-size: 14px;
    color: var(--text-secondary);
    margin-bottom: 4px;
}

.stat-value {
    font-size: 32px;
    font-weight: 800;
    color: var(--text-primary);
}

/* Alerts */
.alert {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
    font-weight: 500;
}

.alert svg {
    stroke-width: 2.5;
}

.alert-success {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: var(--success);
}

.alert-error {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: var(--danger);
}

/* Educations Container */
.educations-container {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
}

.container-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px;
    border-bottom: 1px solid var(--border);
}

.container-title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.container-title svg {
    stroke-width: 2;
}

.info-text {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-secondary);
}

.info-text svg {
    stroke-width: 2;
}

/* Education Card */
.education-card {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    padding: 24px;
    border-bottom: 1px solid var(--border);
    transition: all 0.3s ease;
    cursor: move;
}

.education-card:last-child {
    border-bottom: none;
}

.education-card:hover {
    background: rgba(99, 102, 241, 0.05);
}

.drag-handle {
    color: var(--text-secondary);
    cursor: grab;
    padding: 8px 4px;
    transition: color 0.2s;
}

.drag-handle:hover {
    color: var(--primary);
}

.drag-handle:active {
    cursor: grabbing;
}

.drag-handle svg {
    stroke-width: 2;
}

.education-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 12px;
    flex-shrink: 0;
}

.icon-emoji {
    font-size: 28px;
}

.education-content {
    flex: 1;
    min-width: 0;
}

.education-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
    gap: 16px;
}

.header-left {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.education-degree {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.education-school {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: var(--primary);
}

.education-school svg {
    stroke-width: 2;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    flex-shrink: 0;
}

.status-badge svg {
    stroke-width: 2.5;
}

.badge-active {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.badge-inactive {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

.education-description {
    font-size: 14px;
    line-height: 1.6;
    color: var(--text-secondary);
    margin: 0;
}

/* Action Buttons */
.education-actions {
    display: flex;
    gap: 8px;
    flex-shrink: 0;
}

.action-btn {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: transparent;
    cursor: pointer;
    transition: all 0.2s ease;
    color: var(--text-secondary);
}

.action-btn svg {
    stroke-width: 2;
}

.action-btn:hover {
    transform: translateY(-2px);
}

.btn-edit:hover {
    background: rgba(59, 130, 246, 0.1);
    border-color: #3b82f6;
    color: #3b82f6;
}

.btn-delete:hover {
    background: rgba(239, 68, 68, 0.1);
    border-color: var(--danger);
    color: var(--danger);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 20px;
}

.empty-state svg {
    stroke-width: 1.5;
    color: var(--text-secondary);
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.empty-state p {
    font-size: 14px;
    color: var(--text-secondary);
    margin-bottom: 24px;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-educations-page {
        padding: 16px;
    }

    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .education-card {
        flex-wrap: wrap;
    }

    .education-header {
        flex-direction: column;
        gap: 8px;
    }

    .education-actions {
        width: 100%;
        justify-content: flex-end;
    }

    .container-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.educations-container');
    const cards = container.querySelectorAll('.education-card');

    if (cards.length > 0) {
        const sortable = Sortable.create(container, {
            handle: '.drag-handle',
            animation: 200,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            filter: '.empty-state, .container-header',
            onEnd: function(evt) {
                const order = Array.from(container.querySelectorAll('.education-card'))
                    .map(card => card.dataset.id);

                fetch('{{ route("admin.educations.update-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Ordre mis à jour avec succès');
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la mise à jour de l\'ordre');
                });
            }
        });
    }
});
</script>
@endsection
