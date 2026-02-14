@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="admin-users-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestion des Utilisateurs</h1>
            <p class="page-subtitle">Administrez et gérez tous les utilisateurs de votre plateforme</p>
        </div>
        {{-- <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Nouvel utilisateur
        </a> --}}
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-total">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Utilisateurs</p>
                <h3 class="stat-value">{{ $users->total() }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-admins">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Administrateurs</p>
                <h3 class="stat-value">{{ \App\Models\User::where('role', 'admin')->count() }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-users">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Utilisateurs Standard</p>
                <h3 class="stat-value">{{ \App\Models\User::where('role', 'user')->count() }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-new">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Nouveaux Aujourd'hui</p>
                <h3 class="stat-value">{{ \App\Models\User::whereDate('created_at', today())->count() }}</h3>
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

    <!-- Users Table -->
    <div class="table-container">
        <div class="table-header">
            <h2 class="table-title">Liste des utilisateurs</h2>
            <div class="table-actions">
                <form action="{{ route('admin.users.index') }}" method="GET" class="filters-form">
                    <div class="search-box">
                        <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                        <input
                            type="text"
                            name="search"
                            placeholder="Rechercher par nom ou email..."
                            class="search-input"
                            value="{{ request('search') }}"
                        >
                    </div>

                    <select name="role" class="filter-select">
                        <option value="">🎭 Tous les rôles</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>👑 Administrateur</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>👤 Utilisateur</option>
                    </select>

                    <button type="submit" class="btn btn-filter">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                        Filtrer
                    </button>

                    <a href="{{ route('admin.users.index') }}" class="btn btn-reset">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <polyline points="1 4 1 10 7 10"></polyline>
                            <polyline points="23 20 23 14 17 14"></polyline>
                            <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                        </svg>
                    </a>
                </form>
            </div>
        </div>

        @if($users->isEmpty())
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <h3>Aucun utilisateur trouvé</h3>
                <p>Aucun utilisateur ne correspond à vos critères de recherche</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Réinitialiser les filtres</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Inscription</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <span class="user-id">#{{ $user->id }}</span>
                                </td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="user-details">
                                            <h4>{{ $user->name }}</h4>
                                            @if($user->id === auth()->id())
                                                <span class="user-badge">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                    </svg>
                                                    C'est vous
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="email-info">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge badge-admin">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg>
                                            Administrateur
                                        </span>
                                    @else
                                        <span class="badge badge-user">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                            Utilisateur
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="date-info">
                                        <span class="date">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                            </svg>
                                            {{ $user->created_at->format('d/m/Y') }}
                                        </span>
                                        <span class="time">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                            {{ $user->created_at->format('H:i') }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    @if($user->created_at->isToday())
                                        <span class="status status-new">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="12" cy="12" r="10"></circle>
                                            </svg>
                                            Nouveau
                                        </span>
                                    @else
                                        <span class="status status-active">Actif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="action-btn btn-edit"
                                           title="Modifier">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </a>

                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('⚠️ Êtes-vous absolument sûr de vouloir supprimer {{ $user->name }} ?\n\nCette action est irréversible !');">
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
                                        @else
                                        <button class="action-btn btn-disabled"
                                                disabled
                                                title="Vous ne pouvez pas supprimer votre propre compte">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                                            </svg>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="pagination-container">
                <div class="pagination-info">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span>
                        Affichage de <strong>{{ $users->firstItem() ?? 0 }}</strong> à
                        <strong>{{ $users->lastItem() ?? 0 }}</strong> sur
                        <strong>{{ $users->total() }}</strong> utilisateurs
                    </span>
                </div>
                <div class="pagination-links">
                    {{ $users->links() }}
                </div>
            </div>
            @endif
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

.admin-users-page {
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

.btn-filter {
    background: var(--card-bg);
    color: var(--text-primary);
    border: 1px solid var(--border);
}

.btn-filter:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
}

.btn-reset {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--border);
    padding: 12px;
}

.btn-reset:hover {
    background: var(--card-bg);
    border-color: var(--border);
    color: var(--text-primary);
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

.stat-admins {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    color: white;
}

.stat-users {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    color: white;
}

.stat-new {
    background: linear-gradient(135deg, #43e97b, #38f9d7);
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
    flex-wrap: wrap;
    gap: 16px;
}

.table-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
}

.filters-form {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
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

.filter-select {
    padding: 10px 14px;
    background: var(--dark-bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    color: var(--text-primary);
    font-size: 14px;
    cursor: pointer;
}

.filter-select:focus {
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

.user-id {
    display: inline-block;
    padding: 4px 12px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    border-radius: 8px;
    font-weight: 700;
    font-size: 13px;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 18px;
    flex-shrink: 0;
}

.user-details h4 {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.user-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    color: var(--warning);
    font-weight: 600;
}

.email-info {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-secondary);
}

.email-info svg {
    stroke-width: 2;
}

.badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
}

.badge-admin {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    color: white;
}

.badge-user {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    color: white;
}

.badge svg {
    stroke-width: 2;
}

.date-info {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.date,
.time {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
}

.date {
    font-weight: 600;
    color: var(--text-primary);
}

.time {
    color: var(--text-secondary);
}

.date svg,
.time svg {
    stroke-width: 2;
}

.status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
}

.status-new {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    animation: pulse 2s infinite;
}

.status-active {
    background: rgba(100, 116, 139, 0.1);
    color: #64748b;
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

.action-btn:hover:not(.btn-disabled) {
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

.btn-disabled {
    opacity: 0.4;
    cursor: not-allowed;
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
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-top: 1px solid var(--border);
    flex-wrap: wrap;
    gap: 16px;
}

.pagination-info {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-secondary);
    font-size: 14px;
}

.pagination-info svg {
    stroke-width: 2;
}

.pagination-info strong {
    color: var(--text-primary);
    font-weight: 700;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-users-page {
        padding: 16px;
    }

    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .table-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .filters-form {
        width: 100%;
    }

    .search-input {
        width: 100%;
    }

    .filter-select {
        width: 100%;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .pagination-container {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

@push('scripts')
<script>
    // Auto-dismiss des alertes après 5 secondes
    document.addEventListener('DOMContentLoaded', function() {
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
