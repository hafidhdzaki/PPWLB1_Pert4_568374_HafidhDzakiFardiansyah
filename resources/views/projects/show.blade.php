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
        
        <div style="margin-top: 20px;">
            <a href="{{ route('projects.index') }}" style="padding: 5px 10px; background-color: #6c757d; color: white; text-decoration: none;">
                &larr; Kembali
            </a>
        </div>
        
    </div>
@endsection