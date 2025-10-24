@extends('layout2.app') <!-- Atau layout yang sesuai -->

@section('konten')
<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Tambah Ujian</h4>
            <!-- Tombol Kembali -->
            <a href="{{ route('guru.manajemen-ujian.index') }}" class="btn btn-light text-primary fw-semibold">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('guru.manajemen-ujian.store') }}" method="POST">
                @csrf

                <!-- Judul Ujian -->
                <div class="form-group mb-3">
                    <label for="judul" class="form-label"><strong>Judul Ujian</strong></label>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul ujian" required>
                </div>

                <!-- Mata Pelajaran -->
                <div class="form-group mb-3">
                    <label for="mapel" class="form-label"><strong>Mata Pelajaran</strong></label>
                    <select class="form-control" id="mapel" name="mapel_id" required>
                        <option value="" disabled selected>Pilih mata pelajaran</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Kelas -->
                <div class="form-group mb-3">
                    <label for="kelas" class="form-label"><strong>Kelas</strong></label>
                    <select class="form-control" id="kelas" name="kelas_id" required>
                        <option value="" disabled selected>Pilih kelas</option>
                        @foreach($kelases as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Waktu Pengerjaan -->
                <div class="form-group mb-3">
                    <label for="waktu_pengerjaan" class="form-label"><strong>Waktu Pengerjaan (Menit)</strong></label>
                    <input type="number" class="form-control" id="waktu_pengerjaan" name="waktu_pengerjaan" placeholder="Masukkan waktu pengerjaan" required>
                </div>

                <!-- Info Ujian -->
                <div class="form-group mb-3">
                    <label for="info" class="form-label"><strong>Info Ujian</strong></label>
                    <textarea class="form-control" id="info" name="info_ujian" rows="3" placeholder="Berikan informasi tambahan tentang ujian" required></textarea>
                </div>

                <!-- Bobot Pilihan Ganda dan Essay -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="bobot_pilihan_ganda" class="form-label"><strong>Bobot Pilihan Ganda (%)</strong></label>
                        <input type="number" class="form-control" id="bobot_pilihan_ganda" name="bobot_pilihan_ganda" value="50" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="bobot_essay" class="form-label"><strong>Bobot Essay (%)</strong></label>
                        <input type="number" class="form-control" id="bobot_essay" name="bobot_essay" value="50" required>
                    </div>
                </div>

                <!-- Status Terbit -->
                <div class="form-group mb-4">
                    <label for="terbit" class="form-label"><strong>Terbit?</strong></label>
                    <select class="form-select" id="terbit" name="terbit" required>
                        <option value="Y">Ya</option>
                        <option value="N">Tidak</option>
                    </select>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('guru.manajemen-ujian.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bobotPG = document.getElementById('bobot_pilihan_ganda');
        const bobotEssay = document.getElementById('bobot_essay');

        bobotPG.addEventListener('input', function () {
            const pgValue = parseInt(bobotPG.value) || 0;
            bobotEssay.value = Math.max(0, 100 - pgValue);
        });

        bobotEssay.addEventListener('input', function () {
            const essayValue = parseInt(bobotEssay.value) || 0;
            bobotPG.value = Math.max(0, 100 - essayValue);
        });
    });
</script>
@endsection
