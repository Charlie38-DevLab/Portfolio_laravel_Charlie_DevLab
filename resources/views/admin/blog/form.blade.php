<div class="form-group">
    <label class="form-label">Titre *</label>
    <input type="text" name="title" class="form-input"
           value="{{ old('title', $post->title ?? '') }}" required>
</div>

<div class="form-group">
    <label class="form-label">Extrait *</label>
    <textarea name="excerpt" class="form-textarea" rows="3" required>{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
</div>

<div class="form-group">
    <label class="form-label">Contenu *</label>
    <textarea name="content" class="form-textarea" rows="8" required>{{ old('content', $post->content ?? '') }}</textarea>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
    <div class="form-group">
        <label class="form-label">Catégorie *</label>
        <input type="text" name="category" class="form-input"
               value="{{ old('category', $post->category ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label">Tags</label>
        <input type="text" name="tags" class="form-input"
               placeholder="Laravel, PHP, Web"
               value="{{ old('tags', isset($post) ? implode(', ', $post->tags ?? []) : '') }}">
    </div>
</div>

<div class="form-group">
    <label class="form-label">Image mise en avant</label>
    <input type="file" name="featured_image" class="form-input">
    @isset($post->featured_image)
        <img src="{{ asset('storage/'.$post->featured_image) }}"
             style="margin-top:1rem; max-width:200px; border-radius:10px;">
    @endisset
</div>

<div class="form-group">
    <label style="display:flex; gap:.6rem; align-items:center;">
        <input type="checkbox" name="is_published" value="1"
               {{ old('is_published', $post->is_published ?? false) ? 'checked' : '' }}>
        Publier l’article
    </label>
</div>

<button class="btn btn-primary">
    ✅ Enregistrer
</button>
