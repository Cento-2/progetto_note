@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success') or session('error'))
    <div class="alert alert-{{ session('success') ? 'success' : 'danger' }}">
        {{ session('success') ?? session('error') }}
    </div>
@endif
    <h1>Create Note</h1>

    {{-- **Rimosso il blocco $errors->any()** --}}
    
    <form action="{{ route('notes.store') }}" method="POST" novalidate entype="multipart/form-data">
        @csrf
        
        {{-- Campo Title --}}
        <div class="mb-3">
            <label for="title" class="form-label">Title *</label>
            <input 
                type="text" 
                class="form-control @error('title') is-invalid @enderror" 
                id="title" 
                name="title" 
                value="{{ old('title') }}" 
                required
            >
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Campo Body --}}
        <div class="mb-3">
            <label for="body" class="form-label">Content *</label>
            <textarea 
                class="form-control @error('body') is-invalid @enderror" 
                id="body" 
                name="body" 
                rows="5" 
                required
            >{{ old('body') }}</textarea>
            @error('body')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div> 
            <label for="formFileg" class="form-label">Image</label>
            <input name="image" class="form-control form-control-lg" type="file" id="formFileg" accept="image/*">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('notes.index') }}" class="btn btn-secondary ms-2">Back to Notes</a>
    </form>
</div>
@endsection