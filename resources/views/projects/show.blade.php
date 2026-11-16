@extends('layout.app')

@section('title', 'Detail Project')

@section('content')
    <h1 style="text-align: center;">Detail Project</h1>

    <div style="width: 60%; margin: 0 auto; border: 1px solid #000; padding: 20px;">
        
        <h2 style="margin-top: 0;">
            {{ $projects->title }}
            @if($projects->is_featured)
                <span style="font-size: 13px; background-color: #ffc107; color: #000; padding: 2px 8px; border-radius: 4px; vertical-align: middle;">
                    &#9733; Unggulan
                </span>
            @endif
        </h2>

        @if($projects->short_description)
            <p style="font-style: italic; color: #555; margin-top: -5px;">{{ $projects->short_description }}</p>
        @endif

        <p style="font-size: 14px; color: #444;">
            <strong>Kategori:</strong> {{ $projects->category->name ?? 'Tanpa Kategori' }}
            @if($projects->project_date)
                &nbsp;|&nbsp; <strong>Tanggal Project:</strong> {{ $projects->project_date->format('d M Y') }}
            @endif
            @auth
                @if(Auth::user()->role === 'admin')
                    &nbsp;|&nbsp; <strong>Status:</strong> {{ strtoupper($projects->status) }}
                @endif
            @endauth
        </p>

        @if($projects->thumbnail)
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="{{ asset('storage/' . $projects->thumbnail) }}" alt="{{ $projects->title }}" style="max-width: 100%; max-height: 300px; object-fit: cover; border-radius: 8px;">
            </div>
        @endif
        
        <p><strong>Tools yang digunakan:</strong> {{ $projects->tools }}</p>

        @if($projects->technologies && $projects->technologies->count() > 0)
            <div style="margin-bottom: 15px;">
                <strong>Teknologi:</strong>
                @foreach($projects->technologies as $tech)
                    <span style="background-color: #e9ecef; padding: 3px 8px; border-radius: 4px; font-size: 13px; margin-right: 5px;">
                        {{ $tech->name }}
                    </span>
                @endforeach
            </div>
        @endif

        @if($projects->project_url || $projects->repository_url)
            <div style="margin: 15px 0; display: flex; gap: 10px;">
                @if($projects->project_url)
                    <a href="{{ $projects->project_url }}" target="_blank" rel="noopener noreferrer" style="padding: 6px 14px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; font-size: 14px;">
                        Live Demo &nearr;
                    </a>
                @endif
                @if($projects->repository_url)
                    <a href="{{ $projects->repository_url }}" target="_blank" rel="noopener noreferrer" style="padding: 6px 14px; background-color: #343a40; color: white; text-decoration: none; border-radius: 4px; font-size: 14px;">
                        Repository GitHub &nearr;
                    </a>
                @endif
            </div>
        @endif

        <hr>
        <h3>Galeri Foto Project</h3>

        @if($projects->images && $projects->images->count() > 0)
            <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px;">
                @foreach($projects->images as $img)
                    <div style="border: 1px solid #ccc; padding: 5px; border-radius: 4px;">
                        <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->caption ?: $projects->title }}" style="width: 150px; height: 100px; object-fit: cover; display: block;">
                        @if($img->caption)
                            <small style="display: block; text-align: center; margin-top: 5px;">{{ $img->caption }}</small>
                        @endif

                        @auth
                            @if(Auth::user()->role === 'admin')
                                <form action="{{ route('projects.gallery.destroy', [$projects->id, $img->id]) }}" method="POST" style="margin-top: 5px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus gambar ini?')" style="background-color: #dc3545; color: white; border: none; padding: 2px 6px; font-size: 11px; cursor: pointer;">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: gray; font-style: italic;">Belum ada foto galeri untuk project ini.</p>
        @endif

        @auth
            @if(Auth::user()->role === 'admin')
                <div style="background: #f8f9fa; border: 1px dashed #007bff; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                    <h4 style="margin-top: 0;">+ Tambah Foto Galeri (Khusus Admin)</h4>
                    @if ($errors->any())
                        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 10px; border: 1px solid #f5c6cb;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('projects.gallery.store', $projects->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div style="margin-bottom: 10px;">
                            <input type="file" name="images[]" multiple accept="image/*" required>
                            <small style="display: block; color: gray;">Bisa pilih lebih dari 1 gambar sekaligus (Format: JPG/PNG/WEBP, Min 800px).</small>
                        </div>
                        <button type="submit" style="padding: 5px 15px; background-color: #007bff; color: white; border: none; cursor: pointer;">
                            Unggah ke Galeri
                        </button>
                    </form>
                </div>
            @endif
        @endauth
        
        <hr>
        
        <p><strong>Deskripsi Project:</strong></p>
        <p style="text-align: justify;">{{ $projects->description }}</p>

        <br>
        
        <div style="margin-top: 20px; display: flex; align-items: center; gap: 10px;">
            
            <a href="{{ route('projects.index') }}" style="padding: 5px 10px; background-color: #6c757d; color: white; text-decoration: none;">
                &larr; Kembali
            </a>

            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('projects.edit', $projects->id) }}" style="padding: 5px 10px; background-color: #ffc107; color: black; text-decoration: none;">
                        Edit
                    </a>

                    <form action="{{ route('projects.destroy', $projects->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="padding: 5px 10px; background-color: #dc3545; color: white; border: none; cursor: pointer;" onclick="return confirm('Apakah Anda yakin ingin menghapus project ini?')">
                            Hapus
                        </button>
                    </form>
                @endif
            @endauth

        </div>
        
    </div>
@endsection