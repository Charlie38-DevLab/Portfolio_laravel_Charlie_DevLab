@extends('layouts.admin')

@section('title', 'Gestion des Parcours')

@section('content')
<div class="admin-journeys-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">🧭 Parcours Professionnel</h1>
            <p class="page-subtitle">Gérez les étapes clés de votre parcours professionnel</p>
        </div>
        <a href="{{ route('admin.journeys.create') }}" class="btn btn-primary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Ajouter un parcours
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-total">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Parcours</p>
                <h3 class="stat-value">{{ $journeys->count() }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-active">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Actifs</p>
                <h3 class="stat-value">{{ $journeys->where('is_active', true)->count() }}</h3>
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
                <p class="stat-label">Inactifs</p>
                <h3 class="stat-value">{{ $journeys->where('is_active', false)->count() }}</h3>
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

    <!-- Journeys List -->
    <div class="table-container">
        <div class="table-header">
            <h2 class="table-title">Liste des parcours</h2>
            <div class="drag-info">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                Glissez-déposez pour réorganiser
            </div>
        </div>

        @if($journeys->isEmpty())
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                </svg>
                <h3>Aucun parcours pour le moment</h3>
                <p>Ajoutez votre premier parcours professionnel</p>
                <a href="{{ route('admin.journeys.create') }}" class="btn btn-primary">Ajouter un parcours</a>
            </div>
        @else
            <div class="journeys-list" id="sortable-journeys">
                @foreach($journeys as $journey)
                    <div class="journey-item" data-id="{{ $journey->id }}">
                        <div class="drag-handle">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </div>

                        <div class="journey-year">{{ $journey->year }}</div>

                        <div class="journey-info">
                            <h4 class="journey-title">{{ $journey->title }}</h4>
                            <p class="journey-description">{{ Str::limit($journey->description, 120) }}</p>
                            @if($journey->category)
                                <span class="category-badge badge-{{ $journey->category }}">
                                    {{ ucfirst($journey->category) }}
                                </span>
                            @endif
                        </div>

                        <span class="status-badge {{ $journey->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $journey->is_active ? 'Actif' : 'Inactif' }}
                        </span>

                        <div class="action-buttons">
                            <a href="{{ route('admin.journeys.edit', $journey) }}"
                               class="action-btn btn-edit"
                               title="Modifier">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>

                            <form action="{{ route('admin.journeys.destroy', $journey) }}"
                                  method="POST"
                                  onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce parcours ?');">
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
                @endforeach
            </div>
        @endif
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

.admin-journeys-page {
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

/* Table Container */
.table-container {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px;
    border-bottom: 1px solid var(--border);
}

.table-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
}

.drag-info {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-secondary);
}

.drag-info svg {
    stroke-width: 2;
}

/* Journeys List */
.journeys-list {
    min-height: 200px;
}

.journey-item {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 24px;
    border-bottom: 1px solid var(--border);
    transition: all 0.2s ease;
    cursor: move;
}

.journey-item:hover {
    background: rgba(99, 102, 241, 0.05);
}

.journey-item:last-child {
    border-bottom: none;
}

.drag-handle {
    color: var(--text-secondary);
    cursor: grab;
    flex-shrink: 0;
}

.drag-handle:active {
    cursor: grabbing;
}

.drag-handle svg {
    stroke-width: 2;
}

.journey-year {
    font-size: 14px;
    font-weight: 700;
    color: var(--primary);
    background: rgba(99, 102, 241, 0.1);
    padding: 8px 16px;
    border-radius: 8px;
    flex-shrink: 0;
}

.journey-info {
    flex: 1;
    min-width: 0;
}

.journey-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 6px;
}

.journey-description {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.5;
    margin-bottom: 8px;
}

.category-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

.badge-education {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.badge-experience {
    background: rgba(139, 92, 246, 0.1);
    color: #8b5cf6;
}

.badge-project {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    flex-shrink: 0;
}

.badge-active {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.badge-inactive {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

/* Action Buttons */
.action-buttons {
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
    border-color: #ef4444;
    color: #ef4444;
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
    .admin-journeys-page {
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

    .journey-item {
        flex-wrap: wrap;
        gap: 12px;
    }

    .journey-year {
        order: 1;
    }

    .drag-handle {
        order: 2;
    }

    .journey-info {
        order: 3;
        width: 100%;
    }

    .status-badge {
        order: 4;
    }

    .action-buttons {
        order: 5;
    }
}
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('sortable-journeys');

    if(el) {
        Sortable.create(el, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                const order = Array.from(document.querySelectorAll('.journey-item'))
                    .map(item => item.dataset.id);

                fetch('{{ route("admin.journeys.update-order") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => console.log('Ordre mis à jour'))
                .catch(error => console.error('Erreur:', error));
            }
        });
    }

    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});
</script>
@endpush
@endsection
