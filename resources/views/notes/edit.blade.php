@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success') or session('error'))
    <div class="alert alert-{{ session('success') ? 'success' : 'danger' }}">
        {{ session('success') ?? session('error') }}
    </div>
@endif
    <h1>Edit Note</h1>
    <form action="{{ route('notes.update', $note->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $note->title }}" required>
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea class="form-control" id="body" name="body" rows="5" required>{{ $note->body }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    <div class="mt-3">
        <a href="{{ route('notes.index') }}" class="btn btn-secondary">Back to Notes</a>
</div>
@endsection