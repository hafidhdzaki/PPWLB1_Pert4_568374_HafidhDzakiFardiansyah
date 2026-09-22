@extends('layout.app')

@section('title', 'Home | Hafidh Dzaki Fardiansyah')

@section('content')
    <div style="max-width: 800px; margin: 40px auto; padding: 20px; font-family: sans-serif; text-align: center;">
        
        <img src="{{ asset('img/PAS Foto Biru UGM.png') }}" alt="Foto Profil" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; margin: 0 auto 20px; display: block; border: 4px solid #333;">

        <h1 style="font-size: 2.5rem; color: #333; margin-bottom: 10px;">
            Halo, Perkenalkan Saya Hafidh Dzaki
        </h1>
        
        <h2 style="font-size: 1.2rem; font-weight: normal; color: #666; margin-bottom: 30px;">
            Mahasiswa Teknologi Rekayasa Perangkat Lunak | Software Engineering'25
        </h2>
        
        <p style="font-size: 1.1rem; color: #555; line-height: 1.6; margin-bottom: 40px; max-width: 600px; margin-left: auto; margin-right: auto;">
            Selamat datang di website portofolio yang saya buat. Saya memiliki ketertarikan pada pemrograman, khususnya di Web Development bagian Backend.
        </p>

        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="{{ route('about') }}" style="background-color: #333; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; transition: background 0.3s;">
                Kenal Lebih Dekat
            </a>
            <a href="{{ route('projects.index') }}" style="background-color: #fff; color: #333; border: 2px solid #333; padding: 10px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; transition: all 0.3s;">
                Lihat Portofolio
            </a>
        </div>

    </div>
@endsection