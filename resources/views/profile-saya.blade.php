@extends('layout.app')

@section('title', 'Profil Saya')

@section('content')
    <div style="max-width: 500px; margin: 30px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
        <h2>Data Profil Pengguna</h2>
        <hr>
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role Akses:</strong> {{ ucfirst($user->role) }}</p>
        <p><strong>Bergabung Pada:</strong> {{ $user->created_at->format('d F Y') }}</p>
        
        <a href="{{ route('projects.index') }}" style="display: inline-block; margin-top: 15px;">&laquo; Kembali ke Daftar Project</a>
    </div>
@endsection