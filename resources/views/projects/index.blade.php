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

    <div style="text-align: center; margin-bottom: 20px;">
        <form action="{{ route('projects.index') }}" method="GET" style="display: inline-block;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul project..." style="padding: 5px; width: 250px;">
            
            <select name="per_page" style="padding: 5px;">
                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 Per Halaman</option>
                <option value="10" {{ request('per_page') == 10 || !request('per_page') ? 'selected' : '' }}>10 Per Halaman</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Per Halaman</option>
            </select>
            
            <button type="submit" style="padding: 5px 10px; background-color: #28a745; color: white; border: none;">Terapkan</button>
            <a href="{{ route('projects.index') }}" style="padding: 5px 10px; background-color: #6c757d; color: white; text-decoration: none;">Reset</a>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif

    <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
        
        @forelse($projects as $index => $project)
            <div style="border: 1px solid #000; padding: 15px; width: 300px; overflow-wrap: break-word;">
                
                <small style="color: gray;">Project #{{ $projects->firstItem() + $index }}</small>
                
                <h3>{{ $project->title }}</h3>
                <p><strong>Tools:</strong> {{ $project->tools }}</p>
                <p>{{ $project->description }}</p>
                
                <hr>
                <a href="{{ route('projects.show', $project->id) }}">Lihat Detail</a>
            </div>
        @empty
            <p>Data project tidak ditemukan.</p>
        @endforelse

    </div>

    <div style="margin-top: 20px; text-align: center;">
        <div style="margin-bottom: 10px; font-size: 14px; color: #555;">
            Halaman : {{ $projects->currentPage() }} <br>
            Jumlah Keseluruhan Data : {{ $projects->total() }} <br>
            Data Per Halaman : {{ $projects->perPage() }}
        </div>
        
        <div>
            {{ $projects->links() }}
        </div>
    </div>
@endsection