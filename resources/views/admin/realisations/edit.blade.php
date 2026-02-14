@extends('layouts.admin')

@section('title', 'Éditer - ' . $realisation->title)

@section('content')
<div class="admin-header">
    <h1>Éditer la Réalisation</h1>
    <a href="{{ route('admin.realisations.index') }}" class="btn btn-secondary">
        ← Retour à la liste
    </a>
</div>

<div style="max-width: 900px;">
    <div class="card">

        {{-- FORM UPDATE --}}
        <form action="{{ route('admin.realisations.update', $realisation->id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Titre --}}
            <div class="form-group">
                <label class="form-label">Titre *</label>
                <input type="text"
                       name="title"
                       class="form-input"
                       value="{{ old('title', $realisation->title) }}"
                       required>
            </div>

            {{-- Description --}}
            <div class="form-group">
                <label class="form-label">Description *</label>
                <textarea name="description"
                          class="form-textarea"
                          rows="6"
                          required>{{ old('description', $realisation->description) }}</textarea>
            </div>

            {{-- Catégorie & Client --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">
                <div class="form-group">
                    <label class="form-label">Catégorie *</label>
                    <select name="category" class="form-select" required>
                        @foreach ([
                            'Web Design',
                            'Développement Web',
                            'Application Mobile',
                            'E-commerce',
                            'UI/UX Design',
                            'Autre'
                        ] as $cat)
                            <option value="{{ $cat }}"
                                {{ old('category', $realisation->category) === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Client</label>
                    <input type="text"
                           name="client"
                           class="form-input"
                           value="{{ old('client', $realisation->client) }}">
                </div>
            </div>

            {{-- Image actuelle --}}
            @if($realisation->image)
                <div class="form-group">
                    <label class="form-label">Image actuelle</label><br>
                    <img src="{{ asset('storage/'.$realisation->image) }}"
                         style="max-width:300px;border-radius:10px">
                </div>
            @endif

            {{-- Nouvelle image --}}
            <div class="form-group">
                <label class="form-label">Changer l’image</label>
                <input type="file"
                       name="image"
                       class="form-input"
                       accept="image/*"
                       onchange="previewImage(event)">
            </div>

            <div id="image-preview" style="display:none">
                <img id="preview-img" style="max-width:300px;border-radius:10px">
            </div>

            {{-- Technologies --}}
            <div class="form-group">
                <label class="form-label">Technologies *</label>
                <input type="text"
                       name="technologies"
                       class="form-input"
                       value="{{ old('technologies', implode(', ', (array) $realisation->technologies)) }}"
                       required>
            </div>

            {{-- Date & URL --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">
                <div class="form-group">
                    <label class="form-label">Date *</label>
                    <input type="date"
                           name="completion_date"
                           class="form-input"
                           value="{{ old('completion_date', $realisation->completion_date->format('Y-m-d')) }}"
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label">URL</label>
                    <input type="url"
                           name="project_url"
                           class="form-input"
                           value="{{ old('project_url', $realisation->project_url) }}">
                </div>
            </div>

            {{-- Featured --}}
            <div class="form-group">
                <label style="display:flex;gap:10px;align-items:center">
                    <input type="checkbox"
                           name="featured"
                           value="1"
                           {{ old('featured', $realisation->featured) ? 'checked' : '' }}>
                    ⭐ Mettre en avant
                </label>
            </div>

            {{-- ACTIONS --}}
            <div style="display:flex;justify-content:space-between;margin-top:2rem">
                <a href="{{ route('admin.realisations.index') }}"
                   class="btn btn-secondary">Annuler</a>

                <button type="submit" class="btn btn-primary">
                    ✅ Mettre à jour
                </button>
            </div>
        </form>

        {{-- FORM DELETE (SÉPARÉ, TRÈS IMPORTANT) --}}
        <form action="{{ route('admin.realisations.destroy', $realisation->id) }}"
              method="POST"
              onsubmit="return confirm('Supprimer cette réalisation ?')"
              style="margin-top:1rem">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">🗑️ Supprimer</button>
        </form>

    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('image-preview').style.display = 'block';
        document.getElementById('preview-img').src = e.target.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
