@extends('layout2.app')

@section('konten')
<div class="container">
    <h2>Kirim Pesan</h2>

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

    <form action="{{ route('guru.pesan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="penerima_id">Pilih Penerima</label>
            <select name="penerima_id" class="form-control" required>
                <option value="">Pilih Siswa</option>
                @foreach ($siswa as $data)
                    <option value="{{ $data->id }}">{{ $data->username }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="judul">Judul Pesan</label>
            <input type="text" name="judul" id="judul" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="isi_pesan">Isi Pesan</label>
            <textarea name="isi_pesan" id="isi_pesan" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
    </form>
    </div>
@endsection
