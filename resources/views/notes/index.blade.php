@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Aggiungi questo blocco per i messaggi flash --}}
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
            <th scope="col">User</th>
            <th scope="col">Created at</th>
            <th scope="col">Updated at</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($notes as $note)
            <tr>
                <th scope="row">{{ $note->id }}</th>
                <td><a href="{{route('notes.show',$note->id)}}">{{ $note->title }}</a></td>
                <td>{{ Str::limit($note->title, 20) }}</td>
                <td>{{ Str::limit($note->body, 30) }}</td>
                <td>{{ $note->created_at->format('Y-m-d H:i:s') }}</td>
                <td>{{ $note->updated_at->format('Y-m-d H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <br>
    
    {{ $notes->links() }}
</div>
@endsection