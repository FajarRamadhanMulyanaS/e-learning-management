@extends('layout_new.app')
@section('konten')
<div class="container py-4">
    <h3 class="mb-4">Edit Konten Landing Page</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.landing.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- LOGO -->
        <div class="mb-4">
            <label class="form-label fw-bold">Logo</label>
            <input type="file" name="logo_path" class="form-control mb-2" accept="image/*">
            @if(!empty($contents['logo_path']))
                <img src="{{ asset($contents['logo_path']) }}" alt="Logo" width="120" class="rounded shadow">
            @endif
        </div>

        <!-- FAVICON -->
        <div class="mb-4">
            <label class="form-label fw-bold">Favicon</label>
            <input type="file" name="favicon_path" class="form-control mb-2" accept="image/*">
            @if(!empty($contents['favicon_path']))
                <img src="{{ asset($contents['favicon_path']) }}" alt="Favicon" width="48" class="rounded shadow">
            @endif
        </div>

        <!-- HERO SECTION -->
        <h5 class="mt-4 mb-3 text-primary">Hero Section</h5>
        <div class="mb-3">
            <label class="form-label">Judul Hero</label>
            <input type="text" name="hero_title" value="{{ $contents['hero_title'] ?? '' }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi Hero</label>
            <textarea name="hero_desc" rows="3" class="form-control">{{ $contents['hero_desc'] ?? '' }}</textarea>
        </div>
            <div class="mb-3">
            <label class="form-label">Deskripsi Hero 2</label>
            <textarea name="hero2_desc" rows="3" class="form-control">{{ $contents['hero2_desc'] ?? '' }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Hero Background 1</label>
                <input type="file" name="hero_bg1" class="form-control" accept="image/*">
                @if(!empty($contents['hero_bg1']))
                    <img src="{{ asset($contents['hero_bg1']) }}" alt="Hero 1" width="220" class="mt-2 rounded shadow">
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Hero Background 2</label>
                <input type="file" name="hero_bg2" class="form-control" accept="image/*">
                @if(!empty($contents['hero_bg2']))
                    <img src="{{ asset($contents['hero_bg2']) }}" alt="Hero 2" width="220" class="mt-2 rounded shadow">
                @endif
            </div>
        </div>

        <!-- ABOUT SECTION -->
        <h5 class="mt-4 mb-3 text-primary">Tentang Kami</h5>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="about_text" rows="4" class="form-control">{{ $contents['about_text'] ?? '' }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Gambar About</label>
            <input type="file" name="about_image" class="form-control" accept="image/*">
            @if(!empty($contents['about_image']))
                <img src="{{ asset($contents['about_image']) }}" alt="About Image" width="300" class="mt-2 rounded shadow">
            @endif
        </div>

        <!-- VISI & MISI -->
        <h5 class="mt-4 mb-3 text-primary">Visi & Misi</h5>
        <div class="mb-3">
            <label class="form-label">Visi</label>
            <textarea name="visi" rows="2" class="form-control">{{ $contents['visi'] ?? '' }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Misi</label>
            <textarea name="misi" rows="4" class="form-control">{{ $contents['misi'] ?? '' }}</textarea>
        </div>

        <!-- KONTAK -->
        <h5 class="mt-4 mb-3 text-primary">Kontak</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat" value="{{ $contents['alamat'] ?? '' }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="text" name="email" value="{{ $contents['email'] ?? '' }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Telepon</label>
                <input type="text" name="telepon" value="{{ $contents['telepon'] ?? '' }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Website</label>
                <input type="text" name="website" value="{{ $contents['website'] ?? '' }}" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">💾 Simpan Perubahan</button>
    </form>
</div>
@endsection 