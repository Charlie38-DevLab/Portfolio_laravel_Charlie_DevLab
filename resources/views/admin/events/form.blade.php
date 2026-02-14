@extends('layouts.admin')

@section('content')
<div class="admin-form-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <a href="{{ route('admin.events.index') }}" class="back-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Retour
            </a>
            <h1 class="page-title">{{ isset($event) ? 'Modifier' : 'Créer' }} un événement</h1>
            <p class="page-subtitle">Remplissez tous les champs pour {{ isset($event) ? 'mettre à jour' : 'créer' }} votre événement</p>
        </div>
    </div>

    <!-- Errors -->
    @if($errors->any())
        <div class="alert alert-error">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <div>
                <strong>Erreurs de validation</strong>
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ isset($event) ? route('admin.events.update', $event) : route('admin.events.store') }}"
          method="POST"
          class="event-form">
        @csrf
        @if(isset($event))
            @method('PUT')
        @endif

        <div class="form-grid">
            <!-- Left Column -->
            <div class="form-column">
                <!-- Basic Info Card -->
                <div class="form-card">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                        Informations de base
                    </h3>

                    <div class="form-group">
                        <label for="title" class="form-label required">Titre de l'événement</label>
                        <input type="text"
                               name="title"
                               id="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $event->title ?? '') }}"
                               placeholder="Ex: Webinaire: Débuter en Développement Web en 2025"
                               required>
                        @error('title')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <span class="form-hint">Le slug sera généré automatiquement à partir du titre</span>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="type" class="form-label required">Type d'événement</label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="">Choisir un type</option>
                                @foreach(['webinaire', 'masterclass', 'conference', 'formation', 'atelier'] as $type)
                                    <option value="{{ $type }}"
                                            {{ old('type', $event->type ?? '') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="duration" class="form-label required">Durée</label>
                            <input type="text"
                                   name="duration"
                                   id="duration"
                                   class="form-control @error('duration') is-invalid @enderror"
                                   value="{{ old('duration', $event->duration ?? '') }}"
                                   placeholder="Ex: 90 min"
                                   required>
                            @error('duration')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label required">Description</label>
                        <textarea name="description"
                                  id="description"
                                  class="form-control textarea @error('description') is-invalid @enderror"
                                  rows="6"
                                  placeholder="Décrivez votre événement en détail..."
                                  required>{{ old('description', $event->description ?? '') }}</textarea>
                        @error('description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="features" class="form-label">Points clés / Ce que vous allez apprendre</label>
                        <textarea name="features"
                                  id="features"
                                  class="form-control textarea @error('features') is-invalid @enderror"
                                  rows="4"
                                  placeholder="Listez les points clés (un par ligne)&#10;Ex:&#10;- Introduction aux bases du développement web&#10;- Parcours pour devenir développeur professionnel&#10;- Questions & Réponses en direct">{{ old('features', $event->features ?? '') }}</textarea>
                        @error('features')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Schedule Card -->
                <div class="form-card">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        Date et lieu
                    </h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="event_date" class="form-label required">Date & Heure</label>
                            <input type="datetime-local"
                                   name="event_date"
                                   id="event_date"
                                   class="form-control @error('event_date') is-invalid @enderror"
                                   value="{{ old('event_date', isset($event) ? $event->event_date->format('Y-m-d\TH:i') : '') }}"
                                   required>
                            @error('event_date')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="location" class="form-label required">Lieu</label>
                            <input type="text"
                                   name="location"
                                   id="location"
                                   class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location', $event->location ?? '') }}"
                                   placeholder="Ex: En ligne"
                                   required>
                            @error('location')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="form-column">
                <!-- Pricing Card -->
                <div class="form-card">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                        Tarification
                    </h3>

                    <div class="form-group">
                        <div class="checkbox-card">
                            <input type="checkbox"
                                   name="is_free"
                                   id="is_free"
                                   class="form-checkbox"
                                   {{ old('is_free', $event->is_free ?? false) ? 'checked' : '' }}>
                            <label for="is_free" class="checkbox-label">
                                <span class="checkbox-title">Événement gratuit</span>
                                <span class="checkbox-description">Cet événement est accessible sans frais</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="price-group">
                        <label for="price" class="form-label">Prix (FCFA)</label>
                        <div class="input-group">
                            <input type="number"
                                   name="price"
                                   id="price"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $event->price ?? '') }}"
                                   placeholder="15000"
                                   step="0.01"
                                   min="0">
                            <span class="input-suffix">FCFA</span>
                        </div>
                        @error('price')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <span class="form-hint">Laissez vide si l'événement est gratuit</span>
                    </div>
                </div>

                <!-- Capacity Card -->
                <div class="form-card">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        Participants
                    </h3>

                    <div class="form-group">
                        <label for="max_participants" class="form-label">Nombre maximum de participants</label>
                        <input type="number"
                               name="max_participants"
                               id="max_participants"
                               class="form-control @error('max_participants') is-invalid @enderror"
                               value="{{ old('max_participants', $event->max_participants ?? '') }}"
                               placeholder="100"
                               min="1">
                        @error('max_participants')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <span class="form-hint">Laissez vide pour un nombre illimité</span>
                    </div>

                    @if(isset($event))
                        <div class="info-box">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <div>
                                <strong>{{ $event->registered_count }}</strong> inscription(s) actuellement
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Image Card -->
                <div class="form-card">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                        Image de couverture
                    </h3>

                    <div class="form-group">
                        <label for="image" class="form-label required">URL de l'image</label>
                        <input type="url"
                               name="image"
                               id="image"
                               class="form-control @error('image') is-invalid @enderror"
                               value="{{ old('image', $event->image ?? '') }}"
                               placeholder="https://exemple.com/image.jpg"
                               required>
                        @error('image')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <span class="form-hint">Utilisez une URL publique accessible</span>
                    </div>

                    @if(isset($event) && $event->image)
                        <div class="image-preview">
                            <img src="{{ $event->image }}" alt="Preview" id="imagePreview">
                        </div>
                    @else
                        <div class="image-preview" id="imagePreviewContainer" style="display: none;">
                            <img src="" alt="Preview" id="imagePreview">
                        </div>
                    @endif
                </div>

                <!-- Options Card -->
                <div class="form-card">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M12 1v6m0 6v6m8.66-13.66l-4.24 4.24M7.58 16.42l-4.24 4.24M1 12h6m6 0h6M3.34 3.34l4.24 4.24m8.84 8.84l4.24 4.24"></path>
                        </svg>
                        Options
                    </h3>

                    <div class="form-group">
                        <div class="checkbox-card">
                            <input type="checkbox"
                                   name="is_featured"
                                   id="is_featured"
                                   class="form-checkbox"
                                   {{ old('is_featured', $event->is_featured ?? false) ? 'checked' : '' }}>
                            <label for="is_featured" class="checkbox-label">
                                <span class="checkbox-title">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: #f59e0b;">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                    Événement en vedette
                                </span>
                                <span class="checkbox-description">Mettre en avant sur la page d'accueil</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
                Annuler
            </a>

            <button type="submit" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                {{ isset($event) ? 'Mettre à jour' : 'Créer l\'événement' }}
            </button>
        </div>
    </form>
</div>

<style>
:root {
    --primary: #6366f1;
    --secondary: #8b5cf6;
    --success: #10b981;
    --danger: #ef4444;
    --dark-bg: #0f172a;
    --card-bg: #1e293b;
    --input-bg: #0f172a;
    --text-primary: #f1f5f9;
    --text-secondary: #94a3b8;
    --border: #334155;
}

.admin-form-page {
    padding: 32px;
    background: var(--dark-bg);
    min-height: 100vh;
}

.page-header {
    margin-bottom: 32px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    margin-bottom: 12px;
    transition: all 0.2s ease;
}

.back-link:hover {
    color: var(--primary);
    transform: translateX(-4px);
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

/* Alert */
.alert {
    display: flex;
    gap: 12px;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
}

.alert svg {
    flex-shrink: 0;
    stroke-width: 2;
}

.alert-error {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: var(--danger);
}

.error-list {
    margin-top: 8px;
    margin-left: 20px;
    font-size: 14px;
}

/* Form Layout */
.event-form {
    max-width: 1400px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 450px;
    gap: 24px;
    margin-bottom: 32px;
}

.form-column {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

/* Form Card */
.form-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
}

.card-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
}

.card-title svg {
    stroke-width: 2;
    color: var(--primary);
}

/* Form Elements */
.form-group {
    margin-bottom: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.form-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.form-label.required::after {
    content: '*';
    color: var(--danger);
    margin-left: 4px;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    background: var(--input-bg);
    border: 1px solid var(--border);
    border-radius: 10px;
    color: var(--text-primary);
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.form-control.is-invalid {
    border-color: var(--danger);
}

.textarea {
    resize: vertical;
    min-height: 100px;
    font-family: inherit;
    line-height: 1.6;
}

select.form-control {
    cursor: pointer;
}

.input-group {
    position: relative;
}

.input-suffix {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 500;
    pointer-events: none;
}

.form-hint {
    display: block;
    margin-top: 6px;
    font-size: 12px;
    color: var(--text-secondary);
}

.error-message {
    display: block;
    margin-top: 6px;
    font-size: 12px;
    color: var(--danger);
    font-weight: 500;
}

/* Checkbox Card */
.checkbox-card {
    display: flex;
    gap: 12px;
    padding: 16px;
    background: rgba(99, 102, 241, 0.05);
    border: 2px solid var(--border);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.checkbox-card:has(.form-checkbox:checked) {
    background: rgba(99, 102, 241, 0.1);
    border-color: var(--primary);
}

.form-checkbox {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: var(--primary);
}

.checkbox-label {
    flex: 1;
    cursor: pointer;
}

.checkbox-title {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.checkbox-description {
    font-size: 13px;
    color: var(--text-secondary);
}

/* Image Preview */
.image-preview {
    margin-top: 16px;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid var(--border);
}

.image-preview img {
    width: 100%;
    height: auto;
    display: block;
}

/* Info Box */
.info-box {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: rgba(59, 130, 246, 0.05);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 8px;
    color: #3b82f6;
    font-size: 14px;
}

.info-box svg {
    flex-shrink: 0;
    stroke-width: 2;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 24px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
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
    stroke-width: 2.5;
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
    border: 2px solid var(--border);
}

.btn-secondary:hover {
    border-color: var(--text-secondary);
    color: var(--text-primary);
}

/* Responsive */
@media (max-width: 1024px) {
    .form-grid {
        grid-template-columns: 1fr;
    }

    .admin-form-page {
        padding: 16px;
    }
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
// Image preview
document.getElementById('image')?.addEventListener('input', function(e) {
    const url = e.target.value;
    const container = document.getElementById('imagePreviewContainer');
    const preview = document.getElementById('imagePreview');

    if (url) {
        preview.src = url;
        container.style.display = 'block';

        preview.onerror = function() {
            container.style.display = 'none';
        };
    } else {
        container.style.display = 'none';
    }
});

// Toggle price field based on is_free checkbox
document.getElementById('is_free')?.addEventListener('change', function(e) {
    const priceGroup = document.getElementById('price-group');
    const priceInput = document.getElementById('price');

    if (e.target.checked) {
        priceGroup.style.opacity = '0.5';
        priceGroup.style.pointerEvents = 'none';
        priceInput.value = '';
    } else {
        priceGroup.style.opacity = '1';
        priceGroup.style.pointerEvents = 'auto';
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const isFreeCheckbox = document.getElementById('is_free');
    if (isFreeCheckbox && isFreeCheckbox.checked) {
        const priceGroup = document.getElementById('price-group');
        priceGroup.style.opacity = '0.5';
        priceGroup.style.pointerEvents = 'none';
    }
});
</script>
@endsection



{{-- <div class="row g-3">
    <div class="col-md-6">
        <label>Titre</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $event->title ?? '') }}">
    </div>

    <div class="col-md-6">
        <label>Type</label>
        <select name="type" class="form-select">
            @foreach(['webinaire','masterclass','conference'] as $type)
                <option value="{{ $type }}"
                    @selected(old('type', $event->type ?? '') == $type)>
                    {{ ucfirst($type) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label>Date & heure</label>
        <input type="datetime-local" name="event_date" class="form-control"
               value="{{ old('event_date', isset($event) ? $event->event_date->format('Y-m-d\TH:i') : '') }}">
    </div>

    <div class="col-md-6">
        <label>Durée</label>
        <input type="text" name="duration" class="form-control" value="{{ old('duration', $event->duration ?? '') }}">
    </div>

    <div class="col-md-6">
        <label>Lieu</label>
        <input type="text" name="location" class="form-control" value="{{ old('location', $event->location ?? '') }}">
    </div>

    <div class="col-md-6">
        <label>Prix</label>
        <input type="number" step="0.01" name="price" class="form-control"
               value="{{ old('price', $event->price ?? '') }}">
    </div>

    <div class="col-12">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $event->description ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <label>Image (optionnelle)</label>
        <input type="file" name="image" class="form-control">
        @isset($event->image)
            <img src="{{ asset('storage/'.$event->image) }}" class="mt-2 rounded" width="120">
        @endisset
    </div>

    <div class="col-md-6 form-check">
        <input type="checkbox" name="is_free" class="form-check-input"
               @checked(old('is_free', $event->is_free ?? false))>
        <label class="form-check-label">Événement gratuit</label>
    </div>

    <div class="col-md-6 form-check">
        <input type="checkbox" name="is_featured" class="form-check-input"
               @checked(old('is_featured', $event->is_featured ?? false))>
        <label class="form-check-label">Mis en avant</label>
    </div>
</div> --}}
