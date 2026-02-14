@extends('layouts.admin')

@section('title', 'Créer un Produit')

@section('content')
<div class="admin-header">
    <h1>Créer un Produit</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        ← Retour à la liste
    </a>
</div>

<div style="max-width: 1000px;">
    <div class="card">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Titre -->
            <div class="form-group">
                <label for="title" class="form-label">
                    Titre du produit <span style="color: var(--error);">*</span>
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-input"
                    placeholder="Ex: Formation Laravel Complète"
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
                    placeholder="Décrivez votre produit en détail..."
                    required
                >{{ old('description') }}</textarea>
                @error('description')
                    <p style="color: var(--error); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type -->
            <div class="form-group">
                <label for="type" class="form-label">
                    Type de produit <span style="color: var(--error);">*</span>
                </label>
                <select id="type" name="type" class="form-select" required>
                    <option value="">-- Sélectionner --</option>
                    <option value="ebook" {{ old('type') == 'ebook' ? 'selected' : '' }}>📚 Ebook</option>
                    <option value="formation" {{ old('type') == 'formation' ? 'selected' : '' }}>🎓 Formation</option>
                    <option value="service" {{ old('type') == 'service' ? 'selected' : '' }}>💼 Service</option>
                    <option value="template" {{ old('type') == 'template' ? 'selected' : '' }}>🎨 Template</option>
                    <option value="coaching" {{ old('type') == 'coaching' ? 'selected' : '' }}>👨‍🏫 Coaching</option>
                    <option value="cv/portfolio" {{ old('type') == 'cv/portfolio' ? 'selected' : '' }}>📄 CV/Portfolio</option>
                </select>
                @error('type')
                    <p style="color: var(--error); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Prix -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="price" class="form-label">
                        Prix (FCFA) <span style="color: var(--error);">*</span>
                    </label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        class="form-input"
                        placeholder="15000"
                        value="{{ old('price') }}"
                        min="0"
                        step="0.01"
                        required
                    >
                    @error('price')
                        <p style="color: var(--error); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="old_price" class="form-label">
                        Ancien prix (optionnel)
                    </label>
                    <input
                        type="number"
                        id="old_price"
                        name="old_price"
                        class="form-input"
                        placeholder="25000"
                        value="{{ old('old_price') }}"
                        min="0"
                        step="0.01"
                    >
                    <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 0.5rem;">
                        Pour afficher une réduction
                    </p>
                    @error('old_price')
                        <p style="color: var(--error); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image -->
            <div class="form-group">
                <label for="image" class="form-label">
                    Image du produit <span style="color: var(--error);">*</span>
                </label>
                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/jpeg,image/png,image/jpg,image/webp"
                    class="form-input"
                    onchange="previewImage(event)"
                    required
                >
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 0.5rem;">
                    Formats acceptés : JPG, PNG, WEBP (Max: 2MB)
                </p>

                <!-- Prévisualisation -->
                <div id="image-preview" style="display: none; margin-top: 1rem;">
                    <img id="preview-img" src="" alt="Prévisualisation" style="max-width: 100%; max-height: 300px; border-radius: 10px; border: 1px solid var(--dark-border);">
                </div>

                @error('image')
                    <p style="color: var(--error); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Caractéristiques -->
            <div class="form-group">
                <label for="features" class="form-label">
                    Caractéristiques / Points clés <span style="color: var(--error);">*</span>
                </label>
                <textarea
                    id="features"
                    name="features"
                    class="form-textarea"
                    rows="8"
                    placeholder="Une caractéristique par ligne&#10;Ex:&#10;Accès à vie au contenu&#10;Certificat de réussite&#10;Support par email&#10;Mises à jour gratuites"
                    required
                >{{ old('features') }}</textarea>
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 0.5rem;">
                    ✏️ Séparez chaque caractéristique par un retour à la ligne
                </p>
                @error('features')
                    <p style="color: var(--error); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Options -->
            <div style="display: flex; gap: 2rem; margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.8rem; cursor: pointer;">
                    <input
                        type="checkbox"
                        name="is_popular"
                        value="1"
                        {{ old('is_popular') ? 'checked' : '' }}
                        style="width: 20px; height: 20px; cursor: pointer;"
                    >
                    <span class="form-label" style="margin-bottom: 0;">
                        ⭐ Marquer comme populaire
                    </span>
                </label>

                <label style="display: flex; align-items: center; gap: 0.8rem; cursor: pointer;">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        {{ old('is_active', true) ? 'checked' : '' }}
                        style="width: 20px; height: 20px; cursor: pointer;"
                    >
                    <span class="form-label" style="margin-bottom: 0;">
                        ✅ Produit actif (visible sur le site)
                    </span>
                </label>
            </div>

            <!-- Actions -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--dark-border);">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    ✅ Créer le Produit
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
