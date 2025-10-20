@extends('layout2.app')

@section('konten')
<div class="container my-4">
    <h3 class="text-center mb-4">Manajemen Soal Essay</h3>

    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="h5">Daftar Soal Essay</span>
            <div>
                <a href="{{ route('guru.manajemen-ujian.detailsoal', ['id' => $ujian_id]) }}" class="btn btn-secondary btn-sm">Kembali</a>
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahSoalEssayModal">+ Tambah Soal</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Pertanyaan</th>
                            <th style="width: 15%;">Tanggal Buat</th>
                            <th style="width: 10%;">Edit</th>
                            <th style="width: 10%;">Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($soalEssay as $key => $soal)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ $soal->soal }}</td>
                            <td class="text-center">{{ $soal->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editSoalEssayModal{{ $soal->id }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapusSoalEssayModal{{ $soal->id }}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada soal essay.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginate Links -->
            <div class="d-flex justify-content-center mt-3">
                {{ $soalEssay->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Soal Essay -->
<div class="modal fade" id="tambahSoalEssayModal" tabindex="-1" aria-labelledby="tambahSoalEssayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('guru.manajemen-ujian.essay.store', $ujian_id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahSoalEssayModalLabel">Tambah Soal Essay</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="soal">Pertanyaan</label>
                        <textarea class="form-control" name="soal" rows="4" required></textarea>
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

<!-- Modal Edit Soal Essay -->
@foreach($soalEssay as $soal)
<div class="modal fade" id="editSoalEssayModal{{ $soal->id }}" tabindex="-1" aria-labelledby="editSoalEssayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('guru.manajemen-ujian.essay.update', ['ujian_id' => $ujian_id, 'id' => $soal->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editSoalEssayModalLabel">Edit Soal Essay</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="soal">Soal</label>
                        <textarea class="form-control" name="soal" rows="4" required>{{ $soal->soal }}</textarea>
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

<!-- Modal Hapus Soal Essay -->
@foreach($soalEssay as $soal)
<div class="modal fade" id="hapusSoalEssayModal{{ $soal->id }}" tabindex="-1" aria-labelledby="hapusSoalEssayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('guru.manajemen-ujian.essay.destroy', ['ujian_id' => $ujian_id, 'id' => $soal->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusSoalEssayModalLabel">Hapus Soal Essay</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus soal ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
