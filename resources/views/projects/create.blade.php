@extends('layout.app')

@section('title', 'Tambah Project')

@section('content')
    <h1 style="text-align: center;">Tambah Project Baru</h1>

    <div style="width: 50%; margin: 0 auto; border: 1px solid #000; padding: 20px;">

        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border: 1px solid #f5c6cb;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 15px;">
                <label>Kategori Project:</label><br>
                <select name="category_id" required style="width: 100%; padding: 5px;">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label>Judul Project:</label><br>
                <input type="text" name="title" value="{{ old('title') }}" required style="width: 100%; padding: 5px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label>Ringkasan Singkat (Short Description):</label><br>
                <input type="text" name="short_description" value="{{ old('short_description') }}" placeholder="Ringkasan singkat untuk card project..." style="width: 100%; padding: 5px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label>Tools (Teks Ringkas, Misal: PHP, Figma, Laravel):</label><br>
                <input type="text" name="tools" value="{{ old('tools') }}" required style="width: 100%; padding: 5px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label>Teknologi yang Digunakan (Filter Relasi):</label><br>
                <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 5px;">
                    @foreach($technologies as $tech)
                        <label style="font-weight: normal;">
                            <input type="checkbox" name="technologies[]" value="{{ $tech->id }}"
                                {{ in_array($tech->id, old('technologies', [])) ? 'checked' : '' }}>
                            {{ $tech->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label>Deskripsi Lengkap:</label><br>
                <textarea name="description" rows="5" required style="width: 100%; padding: 5px;">{{ old('description') }}</textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label>Tanggal Project:</label><br>
                <input type="date" name="project_date" value="{{ old('project_date') }}" style="width: 100%; padding: 5px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label>URL Demo Project (Opsional):</label><br>
                <input type="url" name="project_url" value="{{ old('project_url') }}" placeholder="https://..." style="width: 100%; padding: 5px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label>URL Repository GitHub (Opsional):</label><br>
                <input type="url" name="repository_url" value="{{ old('repository_url') }}" placeholder="https://github.com/..." style="width: 100%; padding: 5px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label>Status:</label><br>
                <select name="status" required style="width: 100%; padding: 5px;">
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label>
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    Tampilkan sebagai Project Unggulan (Featured)
                </label>
            </div>

            <div style="margin-bottom: 15px;">
                <label>Thumbnail (Gambar Project):</label><br>
                <input type="file" name="thumbnail" accept="image/*" style="width: 100%; padding: 5px;">
            </div>

            <button type="submit" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; cursor: pointer;">
                Simpan
            </button>
            
            <a href="{{ route('projects.index') }}" style="margin-left: 10px; color: red; text-decoration: none;">
                Batal
            </a>
        </form>

    </div>
@endsection