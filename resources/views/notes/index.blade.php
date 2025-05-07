@extends('layouts.app')

@section('content')
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
            <td> <a href="{{route('notes.show',$note->id)}}">{{ $note->title }}</td>
            <td>{{ $note->body }}</td>
            <td>{{ $note->user->name }}</td>
            <td>{{ $note->created_at }}</td>
            <td>{{ $note->updated_at }}</td>
        </tr>

        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-between">
    <a href="{{ route('notes.create') }}" class="btn btn-primary">Create Note</a>
    <form action="{{ route('notes.index') }}" method="GET" class="form-inline">
    </form>
</div>
<br>

{{ $notes->links() }}

@endsection


