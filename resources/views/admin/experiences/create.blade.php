@extends('layouts.admin')

@section('title', 'Ajouter une Expérience')

@section('content')
<div class="admin-experience-create-page">
    <!-- Breadcrumb -->
    <nav class="breadcrumb-nav" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.experiences.index') }}">Expériences</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Ajouter</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Ajouter une Expérience</h1>
            <p class="page-subtitle">Ajoutez une nouvelle expérience professionnelle à votre parcours</p>
        </div>
        <a href="{{ route('admin.experiences.index') }}" class="btn btn-secondary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Retour
        </a>
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

    @if($errors->any())
        <div class="alert alert-error">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <div>
                <strong>Oops ! Il y a des erreurs :</strong>
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Form Container -->
    <div class="form-container">
        <!-- Info Card -->
        <div class="info-card">
            <div class="info-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
            </div>
            <div class="info-content">
                <h3 class="info-title">💡 Conseils pour une bonne expérience</h3>
                <p class="info-text">Décrivez vos responsabilités, réalisations et compétences développées. Utilisez des verbes d'action et quantifiez vos résultats quand c'est possible.</p>
            </div>
        </div>

        <!-- Main Form -->
        <div class="form-card">
            <form action="{{ route('admin.experiences.store') }}" method="POST" id="experienceForm">
                @csrf

                <!-- Section: Informations Principales -->
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="section-title">Informations Principales</h2>
                            <p class="section-subtitle">Les détails essentiels de votre expérience</p>
                        </div>
                    </div>

                    <!-- Poste -->
                    <div class="form-group">
                        <label for="position" class="form-label">
                            Poste / Titre
                            <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('position') is-invalid @enderror"
                            id="position"
                            name="position"
                            value="{{ old('position') }}"
                            placeholder="Ex: Développeur Web Fullstack"
                            required
                        >
                        <small class="form-text">Le titre de votre poste ou rôle</small>
                        @error('position')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Entreprise -->
                    <div class="form-group">
                        <label for="company" class="form-label">
                            Entreprise / Organisation
                            <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('company') is-invalid @enderror"
                            id="company"
                            name="company"
                            value="{{ old('company') }}"
                            placeholder="Ex: Charlie DevLab, TechCorp"
                            required
                        >
                        <small class="form-text">Le nom de l'entreprise ou organisation</small>
                        @error('company')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Période et Lieu -->
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="period" class="form-label">
                                Période
                                <span class="required">*</span>
                            </label>
                            <input
                                type="text"
                                class="form-control @error('period') is-invalid @enderror"
                                id="period"
                                name="period"
                                value="{{ old('period') }}"
                                placeholder="Ex: 2023 - Présent"
                                required
                            >
                            <small class="form-text">Format: "2023 - Présent" ou "Jan 2022 - Déc 2023"</small>
                            @error('period')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="location" class="form-label">Lieu</label>
                            <input
                                type="text"
                                class="form-control @error('location') is-invalid @enderror"
                                id="location"
                                name="location"
                                value="{{ old('location') }}"
                                placeholder="Ex: Abomey-Calavi, Bénin"
                            >
                            <small class="form-text">Ville, Pays ou "En ligne"</small>
                            @error('location')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description" class="form-label">
                            Description
                            <span class="required">*</span>
                        </label>
                        <textarea
                            class="form-control @error('description') is-invalid @enderror"
                            id="description"
                            name="description"
                            rows="6"
                            placeholder="Décrivez vos responsabilités, réalisations et compétences utilisées...

Exemples:
• Développé et maintenu des applications web avec Laravel et Vue.js
• Collaboré avec une équipe de 5 développeurs sur des projets clients
• Amélioration des performances de 40% grâce à l'optimisation du code"
                            required
                        >{{ old('description') }}</textarea>
                        <div class="textarea-footer">
                            <small class="form-text">Décrivez vos missions, responsabilités et réalisations</small>
                            <small class="char-count" id="charCount">0 caractères</small>
                        </div>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Section: Paramètres -->
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M12 1v6m0 6v6m9-9h-6m-6 0H3"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="section-title">Paramètres d'Affichage</h2>
                            <p class="section-subtitle">Gérez l'ordre et la visibilité</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <!-- Ordre -->
                        <div class="form-group">
                            <label for="order" class="form-label">Ordre d'affichage</label>
                            <input
                                type="number"
                                class="form-control @error('order') is-invalid @enderror"
                                id="order"
                                name="order"
                                value="{{ old('order', 1) }}"
                                min="1"
                                placeholder="1"
                            >
                            <small class="form-text">Position dans la liste (1 = premier)</small>
                            @error('order')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Statut Actif -->
                        <div class="form-group">
                            <label class="form-label">Visibilité</label>
                            <div class="toggle-group">
                                <label class="toggle-switch">
                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        id="is_active"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                    >
                                    <span class="toggle-slider"></span>
                                </label>
                                <label for="is_active" class="toggle-label">
                                    <span class="toggle-text">Actif (visible sur le site public)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <div class="actions-left">
                        <button type="submit" class="btn btn-primary">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                            Enregistrer
                        </button>
                        <a href="{{ route('admin.experiences.index') }}" class="btn btn-secondary">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                            Annuler
                        </a>
                    </div>
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
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #3b82f6;
    --dark-bg: #0f172a;
    --card-bg: #1e293b;
    --text-primary: #f1f5f9;
    --text-secondary: #94a3b8;
    --border: #334155;
}

.admin-experience-create-page {
    padding: 32px;
    background: var(--dark-bg);
    min-height: 100vh;
}

/* Breadcrumb */
.breadcrumb-nav {
    margin-bottom: 24px;
}

.breadcrumb {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    padding: 0;
    margin: 0;
    background-color: transparent;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    font-size: 14px;
}

.breadcrumb-item a {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--text-secondary);
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumb-item a:hover {
    color: var(--primary);
}

.breadcrumb-item a svg {
    stroke-width: 2;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    padding: 0 12px;
    color: var(--text-secondary);
}

.breadcrumb-item.active {
    color: var(--text-primary);
    font-weight: 500;
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

/* Buttons */
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
    background: var(--card-bg);
    color: var(--text-primary);
    border: 1px solid var(--border);
}

.btn-secondary:hover {
    background: var(--border);
}

/* Alerts */
.alert {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
    font-weight: 500;
}

.alert svg {
    stroke-width: 2.5;
    flex-shrink: 0;
    margin-top: 2px;
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

.error-list {
    margin: 8px 0 0 0;
    padding-left: 20px;
}

.error-list li {
    margin-bottom: 4px;
}

/* Form Container */
.form-container {
    max-width: 900px;
    margin: 0 auto;
}

/* Info Card */
.info-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 20px 24px;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(99, 102, 241, 0.1));
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 12px;
    margin-bottom: 24px;
}

.info-icon {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--info);
    border-radius: 10px;
    color: white;
    flex-shrink: 0;
}

.info-icon svg {
    stroke-width: 2;
}

.info-content {
    flex: 1;
}

.info-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.info-text {
    font-size: 14px;
    line-height: 1.6;
    color: var(--text-secondary);
    margin: 0;
}

/* Form Card */
.form-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 32px;
}

/* Form Sections */
.form-section {
    margin-bottom: 40px;
    padding-bottom: 40px;
    border-bottom: 1px solid var(--border);
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 28px;
}

.section-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
    border-radius: 10px;
    color: var(--primary);
}

.section-icon svg {
    stroke-width: 2;
}

.section-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.section-subtitle {
    font-size: 13px;
    color: var(--text-secondary);
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

.form-control {
    width: 100%;
    padding: 12px 16px;
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

textarea.form-control {
    min-height: 180px;
    resize: vertical;
    font-family: inherit;
    line-height: 1.6;
}

.form-text {
    display: block;
    font-size: 12px;
    color: var(--text-secondary);
    margin-top: 6px;
}

.invalid-feedback {
    display: block;
    color: var(--danger);
    font-size: 12px;
    margin-top: 6px;
    font-weight: 500;
}

.textarea-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 6px;
}

.char-count {
    font-size: 12px;
    font-weight: 600;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

/* Toggle Switch */
.toggle-group {
    display: flex;
    align-items: center;
    gap: 12px;
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 52px;
    height: 28px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: var(--border);
    transition: 0.3s;
    border-radius: 34px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.3s;
    border-radius: 50%;
}

input:checked + .toggle-slider {
    background-color: var(--primary);
}

input:checked + .toggle-slider:before {
    transform: translateX(24px);
}

.toggle-label {
    margin: 0;
    cursor: pointer;
}

.toggle-text {
    font-size: 14px;
    color: var(--text-primary);
    font-weight: 500;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 32px;
    border-top: 1px solid var(--border);
    margin-top: 32px;
}

.actions-left {
    display: flex;
    gap: 12px;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-experience-create-page {
        padding: 16px;
    }

    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .form-card {
        padding: 20px;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
        gap: 12px;
    }

    .actions-left {
        width: 100%;
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus sur le premier champ
    document.getElementById('position').focus();

    // Compteur de caractères pour la description
    const description = document.getElementById('description');
    const charCount = document.getElementById('charCount');

    function updateCharCount() {
        const length = description.value.length;
        charCount.textContent = `${length} caractères`;

        if (length < 50) {
            charCount.style.color = '#ef4444';
        } else if (length > 500) {
            charCount.style.color = '#f59e0b';
        } else {
            charCount.style.color = '#10b981';
        }
    }

    description.addEventListener('input', updateCharCount);
    updateCharCount();

    // Animation au focus des inputs
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
        });

        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });

    // Validation en temps réel
    const form = document.getElementById('experienceForm');
    form.addEventListener('submit', function(e) {
        const position = document.getElementById('position').value.trim();
        const company = document.getElementById('company').value.trim();
        const period = document.getElementById('period').value.trim();
        const description = document.getElementById('description').value.trim();

        if (!position || !company || !period || !description) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires');
        }

        if (description.length < 50) {
            e.preventDefault();
            alert('La description doit contenir au moins 50 caractères pour être suffisamment détaillée.');
        }
    });
});
</script>
@endsection
