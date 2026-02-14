@extends('layouts.admin')

@section('title', 'Gestion des Expériences')

@section('content')
<div class="admin-experiences-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestion des Expériences</h1>
            <p class="page-subtitle">Gérez vos expériences professionnelles et parcours de carrière</p>
        </div>
        <a href="{{ route('admin.experiences.create') }}" class="btn btn-primary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Nouvelle expérience
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-total">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Expériences</p>
                <h3 class="stat-value">{{ $experiences->count() }}</h3>
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
                <h3 class="stat-value">{{ $experiences->where('is_active', true)->count() }}</h3>
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
                <h3 class="stat-value">{{ $experiences->where('is_active', false)->count() }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-years">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Années d'expérience</p>
                <h3 class="stat-value">{{ $experiences->count() > 0 ? $experiences->count() : '0' }}+</h3>
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

    <!-- Experiences List -->
    <div class="experiences-container">
        <div class="container-header">
            <h2 class="container-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
                Liste des expériences
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

        @forelse($experiences as $experience)
            <div class="experience-card" data-id="{{ $experience->id }}">
                <div class="drag-handle">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="5" y1="9" x2="19" y2="9"></line>
                        <line x1="5" y1="15" x2="19" y2="15"></line>
                    </svg>
                </div>

                <div class="experience-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                </div>

                <div class="experience-content">
                    <div class="experience-header">
                        <div class="header-left">
                            <h3 class="experience-position">{{ $experience->position }}</h3>
                            <span class="experience-period">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                {{ $experience->period }}
                            </span>
                        </div>
                        <span class="status-badge {{ $experience->is_active ? 'badge-active' : 'badge-inactive' }}">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                @if($experience->is_active)
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                @else
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                @endif
                            </svg>
                            {{ $experience->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="experience-company">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        </svg>
                        {{ $experience->company }}
                        @if($experience->location)
                            <span class="experience-location">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                {{ $experience->location }}
                            </span>
                        @endif
                    </div>

                    <p class="experience-description">{{ Str::limit($experience->description, 150) }}</p>
                </div>

                <div class="experience-actions">
                    <a href="{{ route('admin.experiences.edit', $experience) }}"
                       class="action-btn btn-edit"
                       title="Modifier">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </a>

                    <form action="{{ route('admin.experiences.destroy', $experience) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette expérience ?');">
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
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
                <h3>Aucune expérience</h3>
                <p>Commencez par ajouter votre première expérience professionnelle</p>
                <a href="{{ route('admin.experiences.create') }}" class="btn btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Ajouter une expérience
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

.admin-experiences-page {
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

.stat-years {
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

/* Experiences Container */
.experiences-container {
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

/* Experience Card */
.experience-card {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    padding: 24px;
    border-bottom: 1px solid var(--border);
    transition: all 0.3s ease;
    cursor: move;
}

.experience-card:last-child {
    border-bottom: none;
}

.experience-card:hover {
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

.experience-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 12px;
    color: white;
    flex-shrink: 0;
}

.experience-icon svg {
    stroke-width: 2;
}

.experience-content {
    flex: 1;
    min-width: 0;
}

.experience-header {
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

.experience-position {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.experience-period {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: var(--primary);
}

.experience-period svg {
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

.experience-company {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: var(--success);
    margin-bottom: 12px;
}

.experience-company svg {
    stroke-width: 2;
}

.experience-location {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: var(--text-secondary);
    margin-left: 8px;
}

.experience-location svg {
    stroke-width: 2;
}

.experience-description {
    font-size: 14px;
    line-height: 1.6;
    color: var(--text-secondary);
    margin: 0;
}

/* Action Buttons */
.experience-actions {
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
    .admin-experiences-page {
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

    .experience-card {
        flex-wrap: wrap;
    }

    .experience-header {
        flex-direction: column;
        gap: 8px;
    }

    .experience-actions {
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
    const container = document.querySelector('.experiences-container');
    const cards = container.querySelectorAll('.experience-card');

    if (cards.length > 0) {
        const sortable = Sortable.create(container, {
            handle: '.drag-handle',
            animation: 200,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            filter: '.empty-state, .container-header',
            onEnd: function(evt) {
                const order = Array.from(container.querySelectorAll('.experience-card'))
                    .map(card => card.dataset.id);

                fetch('{{ route("admin.experiences.update-order") }}', {
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
