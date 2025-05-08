@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Aggiungi questo blocco per i messaggi flash --}}
    @if (session('success') or session('error'))
        <div class="alert alert-{{ session('success') ? 'success' : 'danger' }}">
            {{ session('success') ?? session('error') }}
        </div>
    @endif
    <h2>Cestino</h2>
    
    {{-- Aggiungi questo blocco per il messaggio di nessuna nota --}}
    <table class="table">
      
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Body</th>
            <th scope="col">User</th>
            <th scope="col">Created at</th>
            <th scope="col">Eliminated at</th>
            <th scope="col">Azioni</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($notes as $note)
            <tr>
                <th scope="row">{{ $note->id }}</th>
                <td>{{ Str::limit($note->title, 20) }}</td>
                <td>{{ Str::limit($note->body, 30) }}</td>
                <td>{{ $note->user->name }}</td>
                <td>{{ $note->created_at->format('Y-m-d H:i:s') }}</td>
                <td>{{ $note->deleted_at ? $note->deleted_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                <td>
                    <form action="{{ route('notes.restore', $note->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm">Ripristina</button>
                    </form>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <br>
    
    {{ $notes->links() }}
</div>
@endsection