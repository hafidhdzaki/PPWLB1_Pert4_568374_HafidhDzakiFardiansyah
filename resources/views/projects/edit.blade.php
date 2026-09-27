@extends('layout.app')

@section('title', 'Edit Project')

@section('content')
    <h1 style="text-align: center;">Edit Project</h1>

    <div style="width: 50%; margin: 0 auto; border: 1px solid #000; padding: 20px;">
        
        <form action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 15px;">
                <label>Judul Project:</label><br>
                <input type="text" name="title" id="title" value="{{$project->title ?? old('title')}}" required style="width: 100%; padding: 5px;">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label>Tools (Misal: PHP, Figma, Laravel):</label><br>
                <input type="text" name="tools" value="{{ $project->tools ?? old('tools')}}" required style="width: 100%; padding: 5px;">
                @error('tools')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label>Deskripsi:</label><br>
                <textarea name="description" rows="5" required style="width: 100%; padding: 5px;">{{ $project->description ?? old('description')}}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" style="padding: 10px 20px; background-color: #28a745; color: white; border: none;">
                Simpan
            </button>
            
            <a href="{{ route('projects.index') }}" style="margin-left: 10px; color: red; text-decoration: none;">
                Batal
            </a>
        </form>

    </div>
@endsection