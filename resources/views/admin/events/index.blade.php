@extends('layouts.admin')

@section('content')
<div class="admin-events-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestion des Événements</h1>
            <p class="page-subtitle">Créez et gérez vos webinaires, masterclass et conférences</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Nouvel événement
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-total">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Événements</p>
                <h3 class="stat-value">{{ $stats['total'] }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-upcoming">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">À Venir</p>
                <h3 class="stat-value">{{ $stats['upcoming'] }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-completed">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Terminés</p>
                <h3 class="stat-value">{{ $stats['completed'] }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-registrations">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Inscriptions</p>
                <h3 class="stat-value">{{ $stats['total_registrations'] }}</h3>
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

    <!-- Events Table -->
    <div class="table-container">
        <div class="table-header">
            <h2 class="table-title">Liste des événements</h2>
            <div class="table-actions">
                <div class="search-box">
                    <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    <input type="text" placeholder="Rechercher..." class="search-input">
                </div>
            </div>
        </div>

        @if($events->isEmpty())
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <h3>Aucun événement</h3>
                <p>Commencez par créer votre premier événement</p>
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary">Créer un événement</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Lieu</th>
                            <th>Inscrits</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td>
                                    <div class="event-thumbnail">
                                        <img src="{{ $event->image }}" alt="{{ $event->title }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="event-info">
                                        <h4>{{ $event->title }}</h4>
                                        <span class="event-slug">{{ $event->slug }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $event->type }}">
                                        {{ ucfirst($event->type) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="date-info">
                                        <span class="date">{{ $event->event_date->format('d/m/Y') }}</span>
                                        <span class="time">{{ $event->event_date->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td>{{ Str::limit($event->location, 20) }}</td>
                                <td>
                                    <div class="participants-info">
                                        <span class="count">{{ $event->registered_count }}</span>
                                        @if($event->max_participants)
                                            <span class="max">/ {{ $event->max_participants }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($event->event_date > now())
                                        <span class="status status-upcoming">À venir</span>
                                    @elseif($event->event_date > now()->subHours(3))
                                        <span class="status status-live">En direct</span>
                                    @else
                                        <span class="status status-completed">Terminé</span>
                                    @endif

                                    @if($event->is_featured)
                                        <span class="status status-featured">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg>
                                            Vedette
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.events.edit', $event) }}"
                                           class="action-btn btn-edit"
                                           title="Modifier">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </a>

                                        <a href="{{ route('admin.events.registrations', $event) }}"
                                           class="action-btn btn-view"
                                           title="Inscriptions">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                            <span class="badge-count">{{ $event->registered_count }}</span>
                                        </a>

                                        <a href="{{ route('events.show', $event->slug) }}"
                                           class="action-btn btn-preview"
                                           title="Prévisualiser"
                                           target="_blank">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.events.destroy', $event) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                {{ $events->links() }}
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

.admin-events-page {
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

.stat-upcoming {
    background: linear-gradient(135deg, #3b82f6, #06b6d4);
    color: white;
}

.stat-completed {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.stat-registrations {
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

.search-box {
    position: relative;
}

.search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
    stroke-width: 2;
}

.search-input {
    padding: 10px 14px 10px 42px;
    background: var(--dark-bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    color: var(--text-primary);
    font-size: 14px;
    width: 300px;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary);
}

/* Table */
.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead th {
    padding: 16px 20px;
    text-align: left;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid var(--border);
}

.data-table tbody tr {
    border-bottom: 1px solid var(--border);
    transition: all 0.2s ease;
}

.data-table tbody tr:hover {
    background: rgba(99, 102, 241, 0.05);
}

.data-table tbody td {
    padding: 16px 20px;
    font-size: 14px;
    color: var(--text-primary);
}

.event-thumbnail {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
}

.event-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.event-info h4 {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.event-slug {
    font-size: 12px;
    color: var(--text-secondary);
}

.badge {
    padding: 4px 12px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-webinaire { background: #3b82f6; color: white; }
.badge-masterclass { background: #8b5cf6; color: white; }
.badge-conference { background: #10b981; color: white; }
.badge-formation { background: #f59e0b; color: white; }
.badge-atelier { background: #ec4899; color: white; }

.date-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.date {
    font-weight: 600;
    color: var(--text-primary);
}

.time {
    font-size: 12px;
    color: var(--text-secondary);
}

.participants-info {
    display: flex;
    align-items: center;
    gap: 4px;
}

.count {
    font-weight: 700;
    color: var(--primary);
}

.max {
    font-size: 12px;
    color: var(--text-secondary);
}

.status {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    margin-right: 6px;
}

.status-upcoming {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.status-live {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    animation: pulse 2s infinite;
}

.status-completed {
    background: rgba(100, 116, 139, 0.1);
    color: #64748b;
}

.status-featured {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
}

.action-btn {
    position: relative;
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

.btn-view:hover {
    background: rgba(139, 92, 246, 0.1);
    border-color: #8b5cf6;
    color: #8b5cf6;
}

.btn-preview:hover {
    background: rgba(16, 185, 129, 0.1);
    border-color: #10b981;
    color: #10b981;
}

.btn-delete:hover {
    background: rgba(239, 68, 68, 0.1);
    border-color: #ef4444;
    color: #ef4444;
}

.badge-count {
    position: absolute;
    top: -6px;
    right: -6px;
    background: var(--primary);
    color: white;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 10px;
    min-width: 18px;
    text-align: center;
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

/* Pagination */
.pagination-container {
    padding: 20px 24px;
    border-top: 1px solid var(--border);
}

/* Responsive */
@media (max-width: 768px) {
    .admin-events-page {
        padding: 16px;
    }

    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .table-header {
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
    }

    .search-input {
        width: 100%;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
