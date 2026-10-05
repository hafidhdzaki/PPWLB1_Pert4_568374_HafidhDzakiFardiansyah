@extends('layout.app')

@section('title', 'Trash Projects')

@section('content')
    <h1 style="text-align: center;">Trash (Project Terhapus)</h1>

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="{{ route('projects.index') }}" style="padding: 5px 10px; background-color: #6c757d; color: white; text-decoration: none;">
            &larr; Kembali ke Daftar Project
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="color: green; text-align: center;">{{session('success')}}</div>
    @endif

    <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
        
        @forelse($projects as $project)
            <div style="border: 1px solid #000; padding: 15px; width: 300px; background-color: #f8d7da;">
                <h3>{{ $project->title }}</h3>
                <p><strong>Tools:</strong> {{ $project->tools }}</p>
                <p>{{ $project->description }}</p>
                <hr>
                <div style="display: flex; gap: 10px;">
                    <form action="{{ route('projects.restore', $project->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" style="padding: 5px; background-color: #28a745; color: white; border: none; cursor: pointer;">Restore</button>
                    </form>

                    <form action="{{ route('projects.forceDelete', $project->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="padding: 5px; background-color: #dc3545; color: white; border: none; cursor: pointer;" onclick="return confirm('Yakin hapus permanen?')">Hapus Permanen</button>
                    </form>
                </div>
            </div>
        @empty
            <p style="text-align: center;">Tidak ada data di tong sampah.</p>
        @endforelse

    </div>
@endsection