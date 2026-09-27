@extends('layout.app')

@section('title', 'Detail Project')

@section('content')
    <h1 style="text-align: center;">Detail Project</h1>

    <div style="width: 60%; margin: 0 auto; border: 1px solid #000; padding: 20px;">
        
        <h2 style="margin-top: 0;">{{ $projects->title }}</h2>
        
        <p><strong>Tools yang digunakan:</strong> {{ $projects->tools }}</p>
        
        <hr>
        
        <p><strong>Deskripsi Project:</strong></p>
        <p style="text-align: justify;">{{ $projects->description }}</p>

        <br>
        
        <div style="margin-top: 20px; display: flex; align-items: center; gap: 10px;">
            
            <a href="{{ route('projects.index') }}" style="padding: 5px 10px; background-color: #6c757d; color: white; text-decoration: none;">
                &larr; Kembali
            </a>

            <a href="/projects/{{$projects->id}}/edit" style="padding: 5px 10px; background-color: #ffc107; color: black; text-decoration: none;">
                Edit
            </a>

            <form action="{{ route('projects.destroy', $projects->id) }}" method="POST" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" style="padding: 5px 10px; background-color: #dc3545; color: white; border: none; cursor: pointer;" onclick="return confirm('Apakah Anda yakin ingin menghapus project ini?')">
                    Hapus
                </button>
            </form>

        </div>
        
    </div>
@endsection