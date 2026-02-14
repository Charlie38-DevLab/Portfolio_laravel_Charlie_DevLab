@extends('layouts.admin')

@section('title', 'Ajouter un Parcours')

@section('content')
<div class="admin-journeys-create-page">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.journeys.index') }}">Parcours</a></li>
            <li class="breadcrumb-item active">Ajouter</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Ajouter un Parcours</h1>
            <p class="page-subtitle">Ajoutez une nouvelle étape à votre parcours professionnel</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="form-container">
        <div class="form-card">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <div>
                        <strong>Erreurs détectées :</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.journeys.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-section">
                    <h4 class="section-title">Informations Principales</h4>

                    <!-- Année -->
                    <div class="form-group">
                        <label for="year" class="form-label">
                            Année / Période
                            <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <input
                                type="text"
                                name="year"
                                id="year"
                                class="form-control @error('year') is-invalid @enderror"
                                value="{{ old('year') }}"
                                placeholder="Ex: 2025 - Présent, 2023, 2020-2022"
                                required
                            >
                        </div>
                        <small class="form-text">Format suggéré : "2025 - Présent" ou "2023" ou "2020-2022"</small>
                        @error('year')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Titre -->
                    <div class="form-group">
                        <label for="title" class="form-label">
                            Titre
                            <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}"
                                placeholder="Ex: Développeur Fullstack & Formateur"
                                required
                            >
                        </div>
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
                            name="description"
                            id="description"
                            class="form-control @error('description') is-invalid @enderror"
                            rows="5"
                            placeholder="Décrivez cette étape de votre parcours..."
                            required
                        >{{ old('description') }}</textarea>
                        <small class="form-text">Décrivez en détail cette étape (2-3 phrases recommandées)</small>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="divider"></div>

                <div class="form-section">
                    <h4 class="section-title">Informations Complémentaires</h4>

                    <!-- Catégorie -->
                    <div class="form-group">
                        <label for="category" class="form-label">Catégorie</label>
                        <div class="input-with-icon">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <line x1="8" y1="6" x2="21" y2="6"></line>
                                <line x1="8" y1="12" x2="21" y2="12"></line>
                                <line x1="8" y1="18" x2="21" y2="18"></line>
                                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                <line x1="3" y1="18" x2="3.01" y2="18"></line>
                            </svg>
                            <select name="category" id="category" class="form-control">
                                <option value="">-- Sélectionnez une catégorie --</option>
                                <option value="education" {{ old('category') == 'education' ? 'selected' : '' }}>🎓 Éducation</option>
                                <option value="experience" {{ old('category') == 'experience' ? 'selected' : '' }}>💼 Expérience</option>
                                <option value="project" {{ old('category') == 'project' ? 'selected' : '' }}>🚀 Projet</option>
                            </select>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="form-group">
                        <label for="image" class="form-label">Image (optionnelle)</label>
                        <div class="file-input-wrapper">
                            <input
                                type="file"
                                name="image"
                                id="image"
                                class="form-control-file"
                                accept="image/*"
                            >
                            <div class="file-input-label">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                                <span>Cliquez pour sélectionner une image</span>
                            </div>
                        </div>
                        <div class="image-preview-container" id="imagePreviewContainer" style="display: none;">
                            <img id="imagePreview" src="#" alt="Aperçu">
                            <button type="button" class="remove-image" onclick="removeImage()">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Ordre -->
                    <div class="form-group">
                        <label for="order" class="form-label">Ordre d'affichage</label>
                        <div class="input-with-icon">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <line x1="8" y1="6" x2="21" y2="6"></line>
                                <line x1="8" y1="12" x2="21" y2="12"></line>
                                <line x1="8" y1="18" x2="21" y2="18"></line>
                                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                <line x1="3" y1="18" x2="3.01" y2="18"></line>
                            </svg>
                            <input
                                type="number"
                                name="order"
                                id="order"
                                class="form-control"
                                value="{{ old('order', 1) }}"
                                min="1"
                            >
                        </div>
                        <small class="form-text">Position dans la liste (réorganisable par glisser-déposer)</small>
                    </div>

                    <!-- Statut Actif -->
                    <div class="form-check-custom">
                        <input
                            type="checkbox"
                            name="is_active"
                            id="is_active"
                            class="form-check-input"
                            {{ old('is_active', true) ? 'checked' : '' }}
                        >
                        <label for="is_active" class="form-check-label">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            Actif (visible sur le site public)
                        </label>
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
                        Enregistrer
                    </button>
                    <a href="{{ route('admin.journeys.index') }}" class="btn btn-secondary">
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

.admin-journeys-create-page {
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

/* Alerts */
.alert {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
}

.alert svg {
    stroke-width: 2.5;
    flex-shrink: 0;
    margin-top: 2px;
}

.alert-danger {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: var(--danger);
}

.alert ul {
    margin: 8px 0 0 0;
    padding-left: 20px;
}

/* Form Sections */
.form-section {
    margin-bottom: 32px;
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
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

textarea.form-control {
    min-height: 120px;
    resize: vertical;
    padding: 12px 14px;
}

select.form-control {
    cursor: pointer;
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

/* File Input */
.file-input-wrapper {
    position: relative;
}

.form-control-file {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.file-input-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 24px;
    background: var(--dark-bg);
    border: 2px dashed var(--border);
    border-radius: 12px;
    color: var(--text-secondary);
    transition: all 0.2s;
    cursor: pointer;
}

.file-input-label:hover {
    border-color: var(--primary);
    color: var(--primary);
}

.file-input-label svg {
    stroke-width: 2;
}

.image-preview-container {
    position: relative;
    margin-top: 16px;
    border-radius: 12px;
    overflow: hidden;
}

.image-preview-container img {
    width: 100%;
    max-height: 300px;
    object-fit: cover;
    display: block;
}

.remove-image {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 32px;
    height: 32px;
    background: rgba(239, 68, 68, 0.9);
    border: none;
    border-radius: 8px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.remove-image:hover {
    background: var(--danger);
    transform: scale(1.1);
}

/* Checkbox Custom */
.form-check-custom {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    background: rgba(99, 102, 241, 0.05);
    border-radius: 10px;
}

.form-check-input {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: var(--primary);
}

.form-check-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    color: var(--text-primary);
    cursor: pointer;
    margin: 0;
}

.form-check-label svg {
    stroke-width: 2;
    color: var(--primary);
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
    .admin-journeys-create-page {
        padding: 16px;
    }

    .form-card {
        padding: 20px;
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
    // Auto-focus
    document.getElementById('year').focus();

    // Image preview
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('imagePreviewContainer');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Character counter for description
    const description = document.getElementById('description');
    const charCount = document.createElement('small');
    charCount.className = 'form-text';
    charCount.style.float = 'right';

    description.parentNode.insertBefore(charCount, description.nextSibling);

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
});

function removeImage() {
    document.getElementById('image').value = '';
    document.getElementById('imagePreviewContainer').style.display = 'none';
}
</script>
@endpush
@endsection
