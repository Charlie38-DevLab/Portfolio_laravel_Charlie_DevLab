@extends('layouts.admin')

@section('title', 'Modifier l\'Utilisateur')

@section('content')
<div class="admin-users-edit-page">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Utilisateurs</a></li>
            <li class="breadcrumb-item active">Modifier</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Modifier l'Utilisateur</h1>
            <p class="page-subtitle">Modifiez les informations de cet utilisateur</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="form-container">
        <div class="form-card">
            <!-- User Info Badge -->
            <div class="user-info-badge">
                <div class="user-avatar-large">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="user-details">
                    <h3>{{ $user->name }}</h3>
                    <p>{{ $user->email }}</p>
                    <div class="meta-info">
                        <span><strong>ID:</strong> #{{ $user->id }}</span>
                        <span><strong>Créé le:</strong> {{ $user->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h4 class="section-title">Informations Personnelles</h4>

                    <!-- Nom -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            Nom complet
                            <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}"
                                required
                            >
                        </div>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            Adresse email
                            <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}"
                                required
                            >
                        </div>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Rôle -->
                    <div class="form-group">
                        <label for="role" class="form-label">
                            Rôle
                            <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <polyline points="17 11 19 13 23 9"></polyline>
                            </svg>
                            <select
                                name="role"
                                id="role"
                                class="form-control @error('role') is-invalid @enderror"
                                required
                            >
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>
                                    👤 Utilisateur
                                </option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                    👑 Administrateur
                                </option>
                            </select>
                        </div>
                        @error('role')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="divider"></div>

                <div class="form-section">
                    <h4 class="section-title">Modifier le Mot de Passe</h4>
                    <p class="section-description">Laissez vide si vous ne souhaitez pas modifier le mot de passe</p>

                    <!-- Nouveau mot de passe -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            Nouveau mot de passe
                        </label>
                        <div class="input-with-icon">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="••••••••"
                            >
                        </div>
                        <small class="form-text">Minimum 8 caractères</small>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirmation mot de passe -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            Confirmer le mot de passe
                        </label>
                        <div class="input-with-icon">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control"
                                placeholder="••••••••"
                            >
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        Enregistrer les modifications
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
:root {
    --primary: #6366f1;
    --secondary: #8b5cf6;
    --success: #10b981;
    --danger: #ef4444;
    --dark-bg: #0f172a;
    --card-bg: #1e293b;
    --text-primary: #f1f5f9;
    --text-secondary: #94a3b8;
    --border: #334155;
}

.admin-users-edit-page {
    padding: 32px;
    background: var(--dark-bg);
    min-height: 100vh;
}

/* Breadcrumb */
.breadcrumb {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    background: transparent;
}

.breadcrumb-item {
    color: var(--text-secondary);
    font-size: 14px;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    padding: 0 8px;
    color: var(--text-secondary);
}

.breadcrumb-item a {
    color: var(--primary);
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumb-item a:hover {
    color: var(--secondary);
}

.breadcrumb-item.active {
    color: var(--text-primary);
}

/* Header */
.page-header {
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

/* Form Container */
.form-container {
    max-width: 800px;
}

.form-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 32px;
}

/* User Info Badge */
.user-info-badge {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 24px;
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: 12px;
    margin-bottom: 32px;
}

.user-avatar-large {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 800;
    flex-shrink: 0;
}

.user-details h3 {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.user-details p {
    font-size: 14px;
    color: var(--text-secondary);
    margin-bottom: 8px;
}

.meta-info {
    display: flex;
    gap: 16px;
    font-size: 12px;
    color: var(--text-secondary);
}

.meta-info strong {
    color: var(--text-primary);
}

/* Form Sections */
.form-section {
    margin-bottom: 32px;
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.section-description {
    font-size: 14px;
    color: var(--text-secondary);
    margin-bottom: 20px;
}

.divider {
    height: 1px;
    background: var(--border);
    margin: 32px 0;
}

/* Form Groups */
.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
    font-size: 14px;
}

.required {
    color: var(--danger);
    margin-left: 4px;
}

.input-with-icon {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
    stroke-width: 2;
    pointer-events: none;
}

.form-control {
    width: 100%;
    padding: 12px 14px 12px 44px;
    background: var(--dark-bg);
    border: 1px solid var(--border);
    border-radius: 10px;
    color: var(--text-primary);
    font-size: 14px;
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.form-control.is-invalid {
    border-color: var(--danger);
}

.invalid-feedback {
    display: block;
    color: var(--danger);
    font-size: 12px;
    margin-top: 6px;
}

.form-text {
    display: block;
    font-size: 12px;
    color: var(--text-secondary);
    margin-top: 6px;
}

select.form-control {
    cursor: pointer;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 12px;
    padding-top: 24px;
    border-top: 1px solid var(--border);
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

.btn-secondary {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--border);
}

.btn-secondary:hover {
    background: var(--card-bg);
    color: var(--text-primary);
}

/* Responsive */
@media (max-width: 768px) {
    .admin-users-edit-page {
        padding: 16px;
    }

    .form-card {
        padding: 20px;
    }

    .user-info-badge {
        flex-direction: column;
        text-align: center;
    }

    .meta-info {
        flex-direction: column;
        gap: 8px;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus sur le premier champ
    document.getElementById('name').focus();
});
</script>
@endpush
@endsection
