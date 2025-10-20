@extends('layout2.app')

@section('konten')
<div class="text-center mt-4">
    <a href="{{ route('siswa.ujian.kerjakan', ['ujian_id' => $ujian->id]) }}" class="btn btn-info float-right">
        <i class="fas fa-arrow-left"></i> Kerjakan Ujian Lain
    </a>
</div>
<div class="container mt-5">
    <h3 class="mb-4 text-center">Ujian Soal Essay - <strong>{{ $ujian->judul }}</strong></h3>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Jawaban Ujian Essay</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('siswa.ujian.submitEssay', $ujian->id) }}" method="POST">
                @csrf
                @foreach ($soals as $soal)
                    <div class="mb-4">
                        <label for="jawaban_{{ $soal->id }}">
                            <strong>{{ $loop->iteration }}. {{ $soal->soal }}</strong>
                        </label>
                        <textarea name="jawaban[{{ $soal->id }}]" id="jawaban_{{ $soal->id }}" class="form-control" rows="4" placeholder="Tulis jawaban di sini...">{{ old('jawaban.'.$soal->id) }}</textarea>
                    </div>
                @endforeach

                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg px-4">
                        <i class="fas fa-paper-plane"></i> Kirim Jawaban
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
