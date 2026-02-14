@extends('layouts.admin')

@section('title', 'Nouvelle Réalisation')

@section('content')
<div class="admin-header">
    <h1>Nouvelle Réalisation</h1>
    <a href="{{ route('admin.realisations.index') }}" class="btn btn-secondary">
        ← Retour à la liste
    </a>
</div>

<div style="max-width: 900px;">
    <div class="card">
        <form action="{{ route('admin.realisations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Titre -->
            <div class="form-group">
                <label for="title" class="form-label">
                    Titre <span style="color: var(--error);">*</span>
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-input"
                    placeholder="Ex: Site e-commerce Laravel"
                    value="{{ old('title') }}"
                    required
                >
                @error('title')
                    <p style="color: var(--error); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="form-label">
                    Description <span style="color: var(--error);">*</span>
                </label>
                <textarea
                    id="description"
                    name="description"
                    class="form-textarea"
                    rows="6"
                    placeholder="Décrivez le projet en détail..."
                    required
                >{{ old('description') }}</textarea>
                @error('description')
                    <p style="color: var(--error); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catégorie et Client -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="category" class="form-label">
                        Catégorie <span style="color: var(--error);">*</span>
                    </label>
                    <select id="category" name="category" class="form-select" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="Web Design" {{ old('category') == 'Web Design' ? 'selected' : '' }}>Web Design</option>
                        <option value="Développement Web" {{ old('category') == 'Développement Web' ? 'selected' : '' }}>Développement Web</option>
                        <option value="Application Mobile" {{ old('category') == 'Application Mobile' ? 'selected' : '' }}>Application Mobile</option>
                        <option value="E-commerce" {{ old('category') == 'E-commerce' ? 'selected' : '' }}>E-commerce</option>
                        <option value="UI/UX Design" {{ old('category') == 'UI/UX Design' ? 'selected' : '' }}>UI/UX Design</option>
                        <option value="Autre" {{ old('category') == 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('category')
                        <p style="color: var(--error); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="client" class="form-label">
                        Client
                    </label>
                    <input
                        type="text"
                        id="client"
                        name="client"
                        class="form-input"
                        placeholder="Ex: ABC Entreprise"
                        value="{{ old('client') }}"
                    >
                    @error('client')
                        <p style="color: var(--error); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image -->
            <div class="form-group">
                <label for="image" class="form-label">
                    Image du Projet <span style="color: var(--error);">*</span>
                </label>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        class="form-input"
                        onchange="previewImage(event)"
                        required
                    >
                    <p style="color: var(--text-secondary); font-size: 0.85rem;">
                        Formats acceptés : JPG, PNG, WEBP (Max: 2MB)
                    </p>

                    <!-- Prévisualisation -->
                    <div id="image-preview" style="display: none;">
                        <img id="preview-img" src="" alt="Prévisualisation" style="max-width: 100%; max-height: 300px; border-radius: 10px; border: 1px solid var(--dark-border);">
                    </div>
                </div>
                @error('image')
                    <p style="color: var(--error); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Technologies -->
            <div class="form-group">
                <label for="technologies" class="form-label">
                    Technologies <span style="color: var(--error);">*</span>
                </label>
                <input
                    type="text"
                    id="technologies"
                    name="technologies"
                    class="form-input"
                    placeholder="Ex: Laravel, Vue.js, Tailwind CSS, MySQL (séparés par des virgules)"
                    value="{{ old('technologies') }}"
                    required
                >
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 0.5rem;">
                    Séparez les technologies par des virgules
                </p>
                @error('technologies')
                    <p style="color: var(--error); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date et URL -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="completion_date" class="form-label">
                        Date de Réalisation <span style="color: var(--error);">*</span>
                    </label>
                    <input
                        type="date"
                        id="completion_date"
                        name="completion_date"
                        class="form-input"
                        value="{{ old('completion_date') }}"
                        required
                    >
                    @error('completion_date')
                        <p style="color: var(--error); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="project_url" class="form-label">
                        URL du Projet
                    </label>
                    <input
                        type="url"
                        id="project_url"
                        name="project_url"
                        class="form-input"
                        placeholder="https://exemple.com"
                        value="{{ old('project_url') }}"
                    >
                    @error('project_url')
                        <p style="color: var(--error); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Featured -->
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.8rem; cursor: pointer;">
                    <input
                        type="checkbox"
                        name="featured"
                        value="1"
                        {{ old('featured') ? 'checked' : '' }}
                        style="width: 20px; height: 20px; cursor: pointer;"
                    >
                    <span class="form-label" style="margin-bottom: 0;">
                        ⭐ Mettre en avant cette réalisation
                    </span>
                </label>
            </div>

            <!-- Actions -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--dark-border);">
                <a href="{{ route('admin.realisations.index') }}" class="btn btn-secondary">
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    ✅ Créer la Réalisation
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image-preview').style.display = 'block';
            document.getElementById('preview-img').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
