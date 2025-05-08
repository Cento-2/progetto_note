@extends('layouts.app')
@section('content')
<div class="container">
    @if (session('success') or session('error'))
    <div class="alert alert-{{ session('success') ? 'success' : 'danger' }}">
        {{ session('success') ?? session('error') }}
    </div>
@endif
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Body</th>
                <th scope="col">Created by</th>
                <th scope="col">Created at</th>
                <th scope="col">Updated at</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">{{ $note->id }}</th>
                <td>{{ $note->title }}</td>
                <td>{{ $note->body }}</td>
                <td>{{ $note->user->name }}</td>
                <td>{{ $note->created_at }}</td>
                <td>{{ $note->updated_at }}</td>
            </tr>
        </tbody>
    </table>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('notes.index') }}" class="btn btn-primary">Back to Notes</a>
        <div>
            <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-secondary me-2">Edit Note</a>
            
            <!-- Bottone Delete -->
            <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Sei sicuro di voler eliminare questa nota?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Note</button>
            </form>
        </div>
    </div>
</div>
@endsection