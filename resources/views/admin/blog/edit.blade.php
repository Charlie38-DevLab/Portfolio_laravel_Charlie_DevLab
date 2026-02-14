@extends('layouts.admin')

@section('title', 'Modifier - '.$post->title)

@section('content')
<h1>Modifier l’article</h1>

<div class="card" style="max-width:900px;">
    <form action="{{ route('admin.blog.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.blog.form', ['post' => $post])
    </form>
</div>
@endsection
