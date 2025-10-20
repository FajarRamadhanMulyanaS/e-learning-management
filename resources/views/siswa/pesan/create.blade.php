@extends('layout2.app')

@section('konten')
<div class="container">
    <h3>Manajemen Pesan</h3>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pesan.index') }}">Pesan Masuk</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pesan.pengirim') }}">Pesan Terkirim</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('pesan.create') }}">Kirim Pesan</a>
        </li>
    </ul>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mt-3">
        <div class="card-header">
            <h5>Kirim Pesan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pesan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="penerima_id">Kirim Ke:</label>
                    <select name="penerima_id" id="penerima_id" class="form-control" required>
                        <option value="">Pilih Penerima</option>
                        @foreach($guru as $penerima)
                            <option value="{{ $penerima->id }}">{{ $penerima->username }} ({{ $penerima->role }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="judul">Judul Pesan:</label>
                    <input type="text" name="judul" id="judul" class="form-control" placeholder="Judul Pesan" required>
                </div>
                <div class="form-group">
                    <label for="isi_pesan">Isi Pesan:</label>
                    <textarea name="isi_pesan" id="isi_pesan" class="form-control" rows="6" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                <a href="{{ route('pesan.index') }}" class="btn btn-warning">Pesan Keluar</a>
            </form>
        </div>
    </div>
</div>
@endsection
