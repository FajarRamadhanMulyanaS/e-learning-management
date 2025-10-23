@extends('layout_siswa.app')

@section('konten')
<div class="container mt-5">
    <!-- Header Ujian -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h3 class="card-title font-weight-bold">{{ $ujian->judul }}</h3>
            <p class="card-text">Mata Pelajaran: <strong>{{ $ujian->mapel->nama_mapel ?? 'Tidak Ada' }}</strong></p>
            <p class="card-text">Waktu Pengerjaan: <strong>{{ $ujian->waktu_pengerjaan }} Menit</strong></p>
            <a href="{{ route('siswa.ujian.kerjakan', ['ujian_id' => $ujian->id]) }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div id="countdown" class="mt-3"></div>
        </div>
    </div>

    <!-- Form Ujian -->
    <form id="ujianForm" action="{{ route('siswa.ujian.submit.pilgan', $ujian->id) }}" method="POST">
        @csrf

        @foreach($soals as $index => $soal)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Soal #{{ $index + 1 }}</h5>
                <p class="card-text">{{ $soal->soal }}</p>

                <!-- Pilihan Jawaban -->
                <div class="form-check my-2">
                    <input type="radio" class="form-check-input" name="kunci_jawaban[{{ $soal->id }}]" value="A" id="pilihanA{{ $soal->id }}" required>
                    <label for="pilihanA{{ $soal->id }}" class="form-check-label">A. {{ $soal->pilihan_a }}</label>
                </div>
                <div class="form-check my-2">
                    <input type="radio" class="form-check-input" name="kunci_jawaban[{{ $soal->id }}]" value="B" id="pilihanB{{ $soal->id }}">
                    <label for="pilihanB{{ $soal->id }}" class="form-check-label">B. {{ $soal->pilihan_b }}</label>
                </div>
                <div class="form-check my-2">
                    <input type="radio" class="form-check-input" name="kunci_jawaban[{{ $soal->id }}]" value="C" id="pilihanC{{ $soal->id }}">
                    <label for="pilihanC{{ $soal->id }}" class="form-check-label">C. {{ $soal->pilihan_c }}</label>
                </div>
                <div class="form-check my-2">
                    <input type="radio" class="form-check-input" name="kunci_jawaban[{{ $soal->id }}]" value="D" id="pilihanD{{ $soal->id }}">
                    <label for="pilihanD{{ $soal->id }}" class="form-check-label">D. {{ $soal->pilihan_d }}</label>
                </div>
                <div class="form-check my-2">
                    <input type="radio" class="form-check-input" name="kunci_jawaban[{{ $soal->id }}]" value="E" id="pilihanE{{ $soal->id }}">
                    <label for="pilihanE{{ $soal->id }}" class="form-check-label">E. {{ $soal->pilihan_e }}</label>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary btn-block py-3">
            <i class="fas fa-paper-plane"></i> Kirim Jawaban
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Waktu pengerjaan dalam menit
        const waktuPengerjaan = {{ $ujian->waktu_pengerjaan }};
        const totalWaktu = waktuPengerjaan * 60; // Menghitung waktu dalam detik

        // Menampilkan countdown
        let waktuTersisa = totalWaktu;
        const countdownElement = document.getElementById('countdown');

        function updateCountdown() {
            const menit = Math.floor(waktuTersisa / 60);
            const detik = waktuTersisa % 60;
            countdownElement.innerText = `Waktu Tersisa: ${menit} menit ${detik} detik`;

            // Jika waktu habis, submit form
            if (waktuTersisa <= 0) {
                clearInterval(timer);
                document.getElementById('ujianForm').submit();
            }
            waktuTersisa--;
        }

        // Memperbarui countdown setiap detik
        const timer = setInterval(updateCountdown, 1000);
    });
</script>
@endsection
