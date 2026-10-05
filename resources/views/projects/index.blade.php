@extends('layout.app')

@section('title', 'Projects')

@section('content')
    <h1 style="text-align: center;">Daftar Project</h1>

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="{{ route('projects.create') }}" style="padding: 5px 10px; background-color: #007bff; color: white; text-decoration: none;">
            + Tambah Project Baru
        </a>

        <a href="{{ route('projects.trash') }}" style="padding: 5px 10px; background-color: #ffc107; color: black; text-decoration: none;">
            Lihat Trash (Data Terhapus)
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif

    <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
        
        @foreach($projects as $project)
            <div style="border: 1px solid #000; padding: 15px; width: 300px;">
                
                <h3>{{ $project->title }}</h3>
                <p><strong>Tools:</strong> {{ $project->tools }}</p>
                
                <p>{{ $project->description }}</p>
                
                <hr>
                
                <a href="{{ route('projects.show', $project->id) }}">Lihat Detail</a>
                
            </div>
        @endforeach

    </div>
@endsection