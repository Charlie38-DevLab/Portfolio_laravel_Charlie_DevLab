@extends('layouts.admin')

@section('title', 'Éditer - ' . $product->title)

@section('content')
<div class="admin-header">
    <h1>Éditer le Produit</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        ← Retour à la liste
    </a>
</div>

<div style="max-width: 1000px;">
    <div class="card">

        {{-- ================= FORM UPDATE ================= --}}
        <form action="{{ route('admin.products.update', $product->id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Titre -->
            <div class="form-group">
                <label class="form-label">Titre du produit *</label>
                <input type="text"
                       name="title"
                       class="form-input"
                       value="{{ old('title', $product->title) }}"
                       required>
                @error('title') <p class="error">{{ $message }}</p> @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label class="form-label">Description *</label>
                <textarea name="description"
                          class="form-textarea"
                          rows="6"
                          required>{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="error">{{ $message }}</p> @enderror
            </div>

            <!-- Type -->
            <div class="form-group">
                <label class="form-label">Type *</label>
                <select name="type" class="form-select" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach(['ebook','formation','service','template','coaching','cv/portfolio'] as $type)
                        <option value="{{ $type }}"
                            {{ old('type', $product->type) === $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
                @error('type') <p class="error">{{ $message }}</p> @enderror
            </div>

            <!-- Prix -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
                <div class="form-group">
                    <label class="form-label">Prix (FCFA) *</label>
                    <input type="number"
                           name="price"
                           class="form-input"
                           value="{{ old('price', $product->price) }}"
                           min="0"
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label">Ancien prix</label>
                    <input type="number"
                           name="old_price"
                           class="form-input"
                           value="{{ old('old_price', $product->old_price) }}"
                           min="0">
                </div>
            </div>

            <!-- Image actuelle -->
            @if($product->image)
                <div class="form-group">
                    <label class="form-label">Image actuelle</label><br>
                    <img src="{{ asset('storage/'.$product->image) }}"
                         style="max-height:250px;border-radius:10px;">
                </div>
            @endif

            <!-- Nouvelle image -->
            <div class="form-group">
                <label class="form-label">Changer l’image</label>
                <input type="file"
                       name="image"
                       class="form-input"
                       accept="image/*"
                       onchange="previewImage(event)">
                <div id="image-preview" style="display:none;margin-top:1rem;">
                    <img id="preview-img"
                         style="max-height:250px;border-radius:10px;">
                </div>
            </div>

            <!-- Features -->
            <div class="form-group">
                <label class="form-label">Caractéristiques *</label>
                <textarea name="features"
                          rows="7"
                          class="form-textarea"
                          required>{{ old('features', is_array($product->features) ? implode("\n", $product->features) : $product->features) }}</textarea>
            </div>

            <!-- Options -->
            <div style="display:flex;gap:2rem;margin-bottom:2rem;">
                <label>
                    <input type="checkbox"
                           name="is_popular"
                           value="1"
                           {{ old('is_popular', $product->is_popular) ? 'checked' : '' }}>
                    ⭐ Populaire
                </label>

                <label>
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                    ✅ Actif
                </label>
            </div>

            <!-- Boutons UPDATE -->
            <div style="display:flex;justify-content:flex-end;gap:1rem;">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    ✅ Mettre à jour
                </button>
            </div>
        </form>

        {{-- ================= FORM DELETE (SÉPARÉ) ================= --}}
        <form action="{{ route('admin.products.destroy', $product->id) }}"
              method="POST"
              onsubmit="return confirm('Confirmer la suppression ?')"
              style="margin-top:1.5rem;">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger">
                🗑️ Supprimer le produit
            </button>
        </form>

    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('image-preview').style.display = 'block';
        document.getElementById('preview-img').src = e.target.result;
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
