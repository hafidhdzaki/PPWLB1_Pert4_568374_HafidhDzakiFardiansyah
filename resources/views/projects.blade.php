@extends('layout.app')

@section('title', 'Projects | Hafidh Dzaki Fardiansyah')

@section('content')
    <div style="max-width: 900px; margin: 0 auto; padding: 20px; font-family: sans-serif;">
        <h1 style="border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 30px;">
            My Projects
        </h1>
        
        <p style="color: #555; font-size: 1.1rem; margin-bottom: 30px;">
            Berikut adalah beberapa proyek akademik dan eksplorasi pribadi yang mencakup desain UI/UX hingga pengembangan sistem berbasis web.
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">

            <div style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <h2 style="font-size: 1.4rem; color: #333; margin-top: 0;">Bakery Management System</h2>
                <div style="margin-bottom: 15px;">
                    <span style="display: inline-block; background: #e0f7fa; color: #006064; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; margin-right: 5px;">PHP</span>
                    <span style="display: inline-block; background: #e0f7fa; color: #006064; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; margin-right: 5px;">HTML/CSS/JS</span>
                    <span style="display: inline-block; background: #e0f7fa; color: #006064; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Database</span>
                </div>
                <p style="color: #666; line-height: 1.5; font-size: 0.95rem;">
                    Sistem informasi manajemen toko roti berbasis web yang dikembangkan untuk mengelola data operasional. Proyek ini melibatkan perancangan basis data relasional serta implementasi antarmuka yang responsif.
                </p>
            </div>

            <div style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <h2 style="font-size: 1.4rem; color: #333; margin-top: 0;">VEGETA Organic Produce</h2>
                <div style="margin-bottom: 15px;">
                    <span style="display: inline-block; background: #fff3e0; color: #e65100; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; margin-right: 5px;">UI/UX</span>
                    <span style="display: inline-block; background: #fff3e0; color: #e65100; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; margin-right: 5px;">Figma</span>
                    <span style="display: inline-block; background: #fff3e0; color: #e65100; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Branding</span>
                </div>
                <p style="color: #666; line-height: 1.5; font-size: 0.95rem;">
                    Perancangan identitas visual dan aset desain untuk brand sayur mayur dan buah organik bernama VEGETA. Proyek ini mencakup desain logo, kemasan, hingga pembuatan mockup landing page website.
                </p>
            </div>

        </div>
    </div>
@endsection