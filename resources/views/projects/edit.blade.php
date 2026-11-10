@extends('layout.app')

@section('title', 'Edit Project')

@section('content')
    <h1 style="text-align: center;">Edit Project</h1>

    <div style="width: 50%; margin: 0 auto; border: 1px solid #000; padding: 20px;">
        
        <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 15px;">
                <label>Kategori Project:</label><br>
                <select name="category_id" required style="width: 100%; padding: 5px;">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $project->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

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

            <div style="margin-bottom: 15px;">
                <label>Status:</label><br>
                <select name="status" required style="width: 100%; padding: 5px;">
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label>Thumbnail Project:</label><br>
                @if($project->thumbnail)
                    <div style="margin-bottom: 8px;">
                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}" style="max-width: 150px; height: auto; border: 1px solid #ccc;">
                    </div>
                @endif
                <input type="file" name="thumbnail" accept="image/*" style="width: 100%; padding: 5px;">
                <small style="color: gray;">Biarkan kosong jika tidak ingin mengubah gambar thumbnail.</small>
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