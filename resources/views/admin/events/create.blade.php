@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>{{ isset($event) ? 'Modifier' : 'Créer' }} un événement</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($event) ? route('admin.events.update', $event) : route('admin.events.store') }}" method="POST">
        @csrf
        @if(isset($event)) @method('PUT') @endif

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $event->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $event->slug ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" id="type" class="form-control" required>
                @foreach(['webinaire', 'masterclass', 'conference'] as $type)
                    <option value="{{ $type }}" {{ (old('type', $event->type ?? '') == $type) ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="event_date" class="form-label">Date & Heure</label>
            <input type="datetime-local" name="event_date" id="event_date" class="form-control" value="{{ old('event_date', isset($event) ? $event->event_date->format('Y-m-d\TH:i') : '') }}" required>
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label">Durée</label>
            <input type="text" name="duration" id="duration" class="form-control" value="{{ old('duration', $event->duration ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Prix (optionnel)</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price', $event->price ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Lieu</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $event->location ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="max_participants" class="form-label">Nombre max participants (optionnel)</label>
            <input type="number" name="max_participants" id="max_participants" class="form-control" value="{{ old('max_participants', $event->max_participants ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image (URL)</label>
            <input type="text" name="image" id="image" class="form-control" value="{{ old('image', $event->image ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $event->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="features" class="form-label">Features (optionnel)</label>
            <textarea name="features" id="features" class="form-control">{{ old('features', $event->features ?? '') }}</textarea>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_free" id="is_free" class="form-check-input" {{ old('is_free', $event->is_free ?? false) ? 'checked' : '' }}>
            <label for="is_free" class="form-check-label">Gratuit</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" {{ old('is_featured', $event->is_featured ?? false) ? 'checked' : '' }}>
            <label for="is_featured" class="form-check-label">Événement mis en avant</label>
        </div>

        <button class="btn btn-success">{{ isset($event) ? 'Mettre à jour' : 'Créer' }}</button>
    </form>
</div>
@endsection
