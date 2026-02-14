@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="mb-4">✏️ Modifier l’événement</h3>
    <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('admin.events.form')
        <button class="btn btn-primary mt-3">Mettre à jour</button>
    </form>
</div>
@endsection
