@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Note</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('notes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea class="form-control" id="body" name="body" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <div class="mt-3">
        <a href="{{ route('notes.index') }}" class="btn btn-secondary">Back to Notes</a>
</div>
@endsection