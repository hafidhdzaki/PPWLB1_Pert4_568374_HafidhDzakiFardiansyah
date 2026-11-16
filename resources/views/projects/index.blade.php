@extends('layout.app')

@section('title', 'Projects')

@section('content')
    <h1 style="text-align: center;">Daftar Project</h1>

    @auth
        @if(Auth::user()->role === 'admin')
            <div style="text-align: center; margin-bottom: 20px;">
                <a href="{{ route('projects.create') }}" style="padding: 5px 10px; background-color: #007bff; color: white; text-decoration: none;">
                    + Tambah Project Baru
                </a>

                <a href="{{ route('projects.trash') }}" style="padding: 5px 10px; background-color: #ffc107; color: black; text-decoration: none;">
                    Lihat Trash (Data Terhapus)
                </a>
            </div>
        @endif
    @endauth

    <div style="text-align: center; margin-bottom: 15px;">
        <form action="{{ route('projects.index') }}" method="GET" style="display: inline-flex; flex-wrap: wrap; gap: 8px; justify-content: center; align-items: center;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau deskripsi..." style="padding: 5px; width: 220px;">
            
            <select name="category" style="padding: 5px;">
                <option value="">Semua Kategori</option>
                @foreach($categories as $c)
                    <option value="{{ $c->slug }}" {{ request('category') === $c->slug ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>

            <select name="technology" style="padding: 5px;">
                <option value="">Semua Teknologi</option>
                @foreach($technologies as $t)
                    <option value="{{ $t->slug }}" {{ request('technology') === $t->slug ? 'selected' : '' }}>
                        {{ $t->name }}
                    </option>
                @endforeach
            </select>

            @auth
                @if(Auth::user()->role === 'admin')
                    <select name="status" style="padding: 5px;">
                        <option value="">Semua Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                @endif
            @endauth

            <select name="sort" style="padding: 5px;">
                <option value="terbaru" {{ request('sort', 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru (Upload)</option>
                <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Terlama (Upload)</option>
                <option value="az" {{ request('sort') === 'az' ? 'selected' : '' }}>Judul A - Z</option>
                <option value="tanggal_terbaru" {{ request('sort') === 'tanggal_terbaru' ? 'selected' : '' }}>Tanggal Project Terbaru</option>
                <option value="tanggal_terlama" {{ request('sort') === 'tanggal_terlama' ? 'selected' : '' }}>Tanggal Project Terlama</option>
            </select>

            <select name="per_page" style="padding: 5px;">
                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 Per Halaman</option>
                <option value="9" {{ request('per_page', 9) == 9 ? 'selected' : '' }}>9 Per Halaman</option>
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Per Halaman</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Per Halaman</option>
            </select>
            
            <button type="submit" style="padding: 5px 12px; background-color: #28a745; color: white; border: none; cursor: pointer;">Terapkan</button>
            <a href="{{ route('projects.index') }}" style="padding: 5px 12px; background-color: #6c757d; color: white; text-decoration: none;">Reset</a>
        </form>
    </div>

    <p style="text-align: center; font-weight: bold; color: #333; margin-bottom: 20px;">
        {{ $projects->total() }} hasil ditemukan
    </p>

    @if (session('success'))
        <div class="alert alert-success" style="text-align: center; color: green; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
        
        @forelse($projects as $index => $project)
            <div style="border: 1px solid #000; padding: 15px; width: 300px; overflow-wrap: break-word;">
                @if($project->thumbnail)
                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}" style="width: 100%; height: 150px; object-fit: cover; margin-bottom: 10px;">
                @endif    

                <small style="color: gray;">
                    Project #{{ $projects->firstItem() + $index }}
                    @if($project->category)
                        &bull; {{ $project->category->name }}
                    @endif
                    @if($project->is_featured)
                        &bull; <span style="color: #d97706; font-weight: bold;">&#9733; Unggulan</span>
                    @endif
                    @auth
                        @if(Auth::user()->role === 'admin')
                            &bull; <strong>[{{ strtoupper($project->status) }}]</strong>
                        @endif
                    @endauth
                </small>
                
                <h3 style="margin: 8px 0;">{{ $project->title }}</h3>

                @if($project->project_date)
                    <small style="display: block; color: #666; margin-bottom: 6px;">
                        Tanggal: {{ $project->project_date->format('d M Y') }}
                    </small>
                @endif

                <p>{{ $project->short_description ?? Str::limit($project->description, 100) }}</p>

                @if($project->technologies && $project->technologies->count() > 0)
                    <div style="margin: 8px 0; display: flex; flex-wrap: wrap; gap: 4px;">
                        @foreach($project->technologies as $tech)
                            <span style="background-color: #e9ecef; padding: 2px 6px; font-size: 11px; border-radius: 3px;">
                                {{ $tech->name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p><strong>Tools:</strong> {{ $project->tools }}</p>
                @endif
                
                <hr>
                <a href="{{ route('projects.show', $project) }}">Lihat Detail</a>
            </div>
        @empty
            <p style="text-align: center; color: gray;">Tidak ada project yang cocok.</p>
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