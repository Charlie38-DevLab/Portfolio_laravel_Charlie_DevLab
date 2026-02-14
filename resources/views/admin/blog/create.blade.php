@extends('layouts.admin')

@section('title', 'Nouvel Article')

@section('content')
<h1>Créer un article</h1>

<div class="card" style="max-width:900px;">
    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.blog.form')
    </form>
</div>
@endsection
