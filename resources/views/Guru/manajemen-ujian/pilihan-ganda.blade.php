@extends('layout2.app')

@section('konten')
<div class="container">
    <div class="d-flex justify-content-between align-items-center my-4">
        <h3 class="text-primary font-weight-bold">Manajemen Pertanyaan Pilihan Ganda</h3>

    </div>
    <hr class="my-2">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar Pertanyaan Pilihan Ganda</span>
            <div>
                <a href="{{ route('guru.manajemen-ujian.detailsoal', ['id' => $ujian_id]) }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahSoalModal">
                    <i class="fas fa-plus"></i> Tambah Soal
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Pertanyaan</th>
                        <th>Pil A</th>
                        <th>Pil B</th>
                        <th>Pil C</th>
                        <th>Pil D</th>
                        <th>Pil E</th>
                        <th>Kunci Jawaban</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($soalPilihanGanda as $key => $soal)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ Str::limit($soal->soal, 50) }}</td>
                        <td>{{ $soal->pilihan_a }}</td>
                        <td>{{ $soal->pilihan_b }}</td>
                        <td>{{ $soal->pilihan_c }}</td>
                        <td>{{ $soal->pilihan_d }}</td>
                        <td>{{ $soal->pilihan_e }}</td>
                        <td class="text-center"><span class="badge badge-success">{{ $soal->kunci_jawaban }}</span></td>
                        <td class="text-center">
                            <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editSoalModal{{ $soal->id }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapusSoalModal{{ $soal->id }}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Modal Edit Pilihan Ganda -->
                    <div class="modal fade" id="editSoalModal{{ $soal->id }}" tabindex="-1" role="dialog" aria-labelledby="editSoalModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('guru.manajemen-ujian.pilihan-ganda.update', ['ujian_id' => $ujian_id, 'id' => $soal->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="editSoalModalLabel">Edit Soal Pilihan Ganda</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="soal">Pertanyaan</label>
                                            <textarea class="form-control" name="soal" rows="4" required>{{ $soal->soal }}</textarea>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="pilihan_a">Pilihan A</label>
                                                <input type="text" class="form-control" name="pilihan_a" value="{{ $soal->pilihan_a }}" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="pilihan_b">Pilihan B</label>
                                                <input type="text" class="form-control" name="pilihan_b" value="{{ $soal->pilihan_b }}" required>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="pilihan_c">Pilihan C</label>
                                                <input type="text" class="form-control" name="pilihan_c" value="{{ $soal->pilihan_c }}" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="pilihan_d">Pilihan D</label>
                                                <input type="text" class="form-control" name="pilihan_d" value="{{ $soal->pilihan_d }}" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="pilihan_e">Pilihan E</label>
                                            <input type="text" class="form-control" name="pilihan_e" value="{{ $soal->pilihan_e }}" >
                                        </div>

                                        <div class="form-group">
                                            <label for="kunci_jawaban">Kunci Jawaban</label>
                                            <div class="d-flex justify-content-between">
                                                <label class="radio-inline">
                                                    <input type="radio" name="kunci_jawaban" value="A" {{ $soal->kunci_jawaban == 'A' ? 'checked' : '' }}> Pilihan A
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="kunci_jawaban" value="B" {{ $soal->kunci_jawaban == 'B' ? 'checked' : '' }}> Pilihan B
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="kunci_jawaban" value="C" {{ $soal->kunci_jawaban == 'C' ? 'checked' : '' }}> Pilihan C
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="kunci_jawaban" value="D" {{ $soal->kunci_jawaban == 'D' ? 'checked' : '' }}> Pilihan D
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="kunci_jawaban" value="E" {{ $soal->kunci_jawaban == 'E' ? 'checked' : '' }}> Pilihan E
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>

            <!-- Paginate Links -->
            <div class="d-flex justify-content-end mt-3">
                {{ $soalPilihanGanda->links() }}
            </div>
        </div>
    </div>
</div>


<!-- Modal Tambah Soal -->
<div class="modal fade" id="tambahSoalModal" tabindex="-1" role="dialog" aria-labelledby="tambahSoalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('guru.manajemen-ujian.pilihan-ganda.storePilgan', $ujian_id) }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahSoalModalLabel">Tambah Soal Pilihan Ganda</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="soal">Pertanyaan</label>
                        <textarea class="form-control" name="soal" rows="4" placeholder="Masukkan pertanyaan..." required></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pilihan_a">Pilihan A</label>
                            <input type="text" class="form-control" name="pilihan_a" placeholder="Pilihan A" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pilihan_b">Pilihan B</label>
                            <input type="text" class="form-control" name="pilihan_b" placeholder="Pilihan B" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pilihan_c">Pilihan C</label>
                            <input type="text" class="form-control" name="pilihan_c" placeholder="Pilihan C" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pilihan_d">Pilihan D</label>
                            <input type="text" class="form-control" name="pilihan_d" placeholder="Pilihan D" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pilihan_e">Pilihan E</label>
                        <input type="text" class="form-control" name="pilihan_e" placeholder="Pilihan E" >
                    </div>

                    <div class="form-group">
                        <label for="kunci_jawaban">Kunci Jawaban</label>
                        <div class="d-flex justify-content-between">
                            <label class="radio-inline">
                                <input type="radio" name="kunci_jawaban" value="A" required> Pilihan A
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="kunci_jawaban" value="B" required> Pilihan B
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="kunci_jawaban" value="C" required> Pilihan C
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="kunci_jawaban" value="D" required> Pilihan D
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="kunci_jawaban" value="E" required> Pilihan E
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
