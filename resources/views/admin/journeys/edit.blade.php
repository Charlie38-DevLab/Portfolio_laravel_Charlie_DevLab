@extends('layouts.admin')

@section('title', 'Modifier le Parcours')

@section('content')
<div class="admin-journey-edit-page">
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
                <a href="{{ route('admin.journeys.index') }}">Parcours</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Modifier</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Modifier le Parcours</h1>
            <p class="page-subtitle">Modifiez les informations de cette étape de votre parcours professionnel</p>
        </div>
        <a href="{{ route('admin.journeys.index') }}" class="btn btn-secondary">
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
        <!-- Meta Info Card -->
        <div class="meta-card">
            <div class="meta-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="meta-content">
                <div class="meta-item">
                    <span class="meta-label">Créé le :</span>
                    <span class="meta-value">{{ $journey->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                @if($journey->updated_at != $journey->created_at)
                    <div class="meta-item">
                        <span class="meta-label">Dernière modification :</span>
                        <span class="meta-value">{{ $journey->updated_at->format('d/m/Y à H:i') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Main Form -->
        <div class="form-card">
            <form action="{{ route('admin.journeys.update', $journey) }}" method="POST" enctype="multipart/form-data" id="journeyForm">
                @csrf
                @method('PUT')

                <!-- Section: Informations Principales -->
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <div>
                            <h2 class="section-title">Informations Principales</h2>
                            <p class="section-subtitle">Les détails essentiels de votre parcours</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <!-- Année -->
                        <div class="form-group">
                            <label for="year" class="form-label">
                                Année / Période
                                <span class="required">*</span>
                            </label>
                            <input
                                type="text"
                                class="form-control @error('year') is-invalid @enderror"
                                id="year"
                                name="year"
                                value="{{ old('year', $journey->year) }}"
                                placeholder="Ex: 2025 - Présent"
                                required
                            >
                            <small class="form-text">Format suggéré : "2025 - Présent" ou "2023" ou "2020-2022"</small>
                            @error('year')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Catégorie -->
                        <div class="form-group">
                            <label for="category" class="form-label">Catégorie</label>
                            <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                <option value="">-- Sélectionnez une catégorie --</option>
                                <option value="education" {{ old('category', $journey->category) == 'education' ? 'selected' : '' }}>
                                    🎓 Éducation
                                </option>
                                <option value="experience" {{ old('category', $journey->category) == 'experience' ? 'selected' : '' }}>
                                    💼 Expérience Professionnelle
                                </option>
                                <option value="project" {{ old('category', $journey->category) == 'project' ? 'selected' : '' }}>
                                    🚀 Projet Personnel
                                </option>
                            </select>
                            <small class="form-text">Classez cette étape par type</small>
                            @error('category')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Titre -->
                    <div class="form-group">
                        <label for="title" class="form-label">
                            Titre
                            <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('title') is-invalid @enderror"
                            id="title"
                            name="title"
                            value="{{ old('title', $journey->title) }}"
                            placeholder="Ex: Développeur Fullstack & Formateur"
                            required
                        >
                        <small class="form-text">Le titre de cette étape de votre parcours</small>
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
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
                            placeholder="Décrivez cette étape de votre parcours en détail..."
                            required
                        >{{ old('description', $journey->description) }}</textarea>
                        <div class="textarea-footer">
                            <small class="form-text">Décrivez vos responsabilités, réalisations et compétences acquises</small>
                            <small class="char-count" id="charCount">0 caractères</small>
                        </div>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Section: Image et Média -->
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                        </div>
                        <div>
                            <h2 class="section-title">Image & Média</h2>
                            <p class="section-subtitle">Ajoutez une image pour illustrer cette étape</p>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="form-group">
                        <label for="image" class="form-label">Image (optionnelle)</label>
                        <div class="image-upload-zone" id="imageUploadZone">
                            <input
                                type="file"
                                name="image"
                                id="image"
                                class="image-input"
                                accept="image/*"
                            >
                            <div class="upload-placeholder" id="uploadPlaceholder">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                                <p class="upload-text"><strong>Cliquez pour uploader</strong> ou glissez-déposez</p>
                                <p class="upload-hint">PNG, JPG, GIF jusqu'à 5MB</p>
                            </div>
                            @if($journey->image)
                                <img id="imagePreview" class="image-preview" src="{{ asset('storage/' . $journey->image) }}" alt="Aperçu">
                            @else
                                <img id="imagePreview" class="image-preview" src="#" alt="Aperçu" style="display: none;">
                            @endif
                        </div>
                        <small class="form-text">Recommandé : 1200x600px pour un meilleur rendu</small>
                        @error('image')
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
                            <label for="order" class="form-label">
                                Ordre d'affichage
                            </label>
                            <input
                                type="number"
                                class="form-control @error('order') is-invalid @enderror"
                                id="order"
                                name="order"
                                value="{{ old('order', $journey->order) }}"
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
                                        {{ old('is_active', $journey->is_active) ? 'checked' : '' }}
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
                            Mettre à jour
                        </button>
                        <a href="{{ route('admin.journeys.index') }}" class="btn btn-secondary">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                            Annuler
                        </a>
                    </div>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                        Supprimer
                    </button>
                </div>
            </form>

            <!-- Formulaire de suppression caché -->
            <form id="delete-form" action="{{ route('admin.journeys.destroy', $journey) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
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
    --dark-bg: #0f172a;
    --card-bg: #1e293b;
    --text-primary: #f1f5f9;
    --text-secondary: #94a3b8;
    --border: #334155;
}

.admin-journey-edit-page {
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

.btn-danger {
    background: var(--danger);
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(239, 68, 68, 0.3);
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

/* Meta Card */
.meta-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px 24px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    margin-bottom: 24px;
}

.meta-icon {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 10px;
    color: white;
}

.meta-icon svg {
    stroke-width: 2;
}

.meta-content {
    flex: 1;
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    gap: 8px;
}

.meta-label {
    font-size: 13px;
    color: var(--text-secondary);
    font-weight: 500;
}

.meta-value {
    font-size: 13px;
    color: var(--text-primary);
    font-weight: 600;
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

.form-control, select {
    width: 100%;
    padding: 12px 16px;
    background: var(--dark-bg);
    border: 1px solid var(--border);
    border-radius: 10px;
    color: var(--text-primary);
    font-size: 14px;
    transition: all 0.2s;
}

.form-control:focus, select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.form-control.is-invalid, select.is-invalid {
    border-color: var(--danger);
}

textarea.form-control {
    min-height: 150px;
    resize: vertical;
    font-family: inherit;
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

/* Image Upload */
.image-upload-zone {
    position: relative;
    border: 2px dashed var(--border);
    border-radius: 12px;
    padding: 32px;
    text-align: center;
    transition: all 0.3s;
    cursor: pointer;
}

.image-upload-zone:hover {
    border-color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
}

.image-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.upload-placeholder {
    pointer-events: none;
}

.upload-placeholder svg {
    color: var(--text-secondary);
    stroke-width: 1.5;
    margin-bottom: 16px;
}

.upload-text {
    font-size: 14px;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.upload-text strong {
    color: var(--primary);
}

.upload-hint {
    font-size: 12px;
    color: var(--text-secondary);
}

.image-preview {
    max-width: 100%;
    max-height: 300px;
    border-radius: 12px;
    margin-top: 16px;
    object-fit: cover;
    border: 1px solid var(--border);
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
    .admin-journey-edit-page {
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

    .meta-content {
        flex-direction: column;
        gap: 12px;
    }
}
</style>

<script>
// Confirmation de suppression
function confirmDelete() {
    if (confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce parcours ?\n\nCette action est irréversible.')) {
        document.getElementById('delete-form').submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
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

    // Aperçu de l'image
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const imageUploadZone = document.getElementById('imageUploadZone');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Vérification du type de fichier
            if (!file.type.startsWith('image/')) {
                alert('Veuillez sélectionner une image valide');
                return;
            }

            // Vérification de la taille (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                alert('L\'image ne doit pas dépasser 5MB');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                uploadPlaceholder.style.display = 'none';
                imageUploadZone.style.borderStyle = 'solid';
            }
            reader.readAsDataURL(file);
        }
    });

    // Drag and drop pour l'image
    imageUploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = 'var(--primary)';
        this.style.background = 'rgba(99, 102, 241, 0.05)';
    });

    imageUploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.borderColor = 'var(--border)';
        this.style.background = 'transparent';
    });

    imageUploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = 'var(--border)';
        this.style.background = 'transparent';

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            imageInput.dispatchEvent(new Event('change'));
        }
    });

    // Animation au focus des inputs
    const inputs = document.querySelectorAll('.form-control, select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
        });

        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });

    // Validation en temps réel
    const form = document.getElementById('journeyForm');
    form.addEventListener('submit', function(e) {
        const year = document.getElementById('year').value.trim();
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();

        if (!year || !title || !description) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires');
        }
    });
});
</script>
@endsection
