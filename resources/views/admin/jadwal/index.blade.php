@extends('layout_new.app')
@section('konten')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Manajemen Jadwal</h3>
        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">Tambah Jadwal</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                            <th>Semester</th>
                            <th>Ruang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwal as $index => $item)
                            <tr>
                                <td>{{ $jadwal->firstItem() + $index }}</td>
                                <td>{{ $item->hari }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Illuminate\Support\Carbon::parse($item->jam_selesai)->format('H:i') }}</td>
                                <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $item->mapel->nama_mapel ?? '-' }}</td>
                                <td>{{ $item->guru->nama_guru ?? '-' }}</td>
                                <td>{{ optional($item->semester)->nama_semester }} {{ optional($item->semester)->tahun_ajaran }}</td>
                                <td>{{ $item->ruang ?? '-' }}</td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('admin.jadwal.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.jadwal.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada data jadwal</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $jadwal->links() }}
            </div>
        </div>
    </div>
</div>

@endsection


