@extends('layout2.app')

@section('konten')

<style>
    /* Tambahan Styling */
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #4CAF50;
        color: white;
        text-align: center;
        font-weight: bold;
        font-size: 18px;
    }

    .card-body {
        padding: 20px;
    }

    .video-thumbnail {
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        height: 180px;
        background-color: #f4f4f4;
    }

    .video-thumbnail iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    .btn-view {
        background-color: #4CAF50;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        background-color: #45a049;
        transform: scale(1.05);
    }

    .text-muted {
        font-size: 14px;
    }
</style>
<title>Video</title>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-video"></i> Materi Video Pembelajaran
        </div>
        <div class="card-body">
            <!-- Tampilkan Pesan -->
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            <!-- Daftar Video -->
            <div class="row">
                @forelse($videos as $video)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="video-thumbnail">
                            @if($video->link_youtube)
                                <!-- Parsing YouTube ID -->
                                @php
                                    parse_str(parse_url($video->link_youtube, PHP_URL_QUERY), $ytParams);
                                    $youtubeId = $ytParams['v'] ?? null;
                                @endphp
                                @if($youtubeId)
                                    <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}" allowfullscreen></iframe>
                                @else
                                    <p class="text-danger">Invalid YouTube link.</p>
                                @endif
                            @else
                                <!-- Video Lokal -->
                                <video controls style="width: 100%; height: 100%;">
                                    <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
                                    Video tidak tersedia.
                                </video>
                            @endif
                        </div>

                        <div class="card-body">
                            <h6 class="card-title text-success"><b>{{ $video->judul }}</b></h6>
                            <p class="text-muted">Mata Pelajaran: {{ $video->mapel->nama_mapel ?? 'Tidak Ada' }}</p>
                            <p class="text-muted">Kelas: {{ $video->kelas->nama_kelas ?? 'Semua Kelas' }}</p>
                            @if($video->link_youtube)
                            <a href="{{ $video->link_youtube }}" target="_blank" class="btn btn-view btn-sm">
                                <i class="fab fa-youtube"></i> Tonton di YouTube
                            </a>
                            @else
                            <a href="{{ asset('storage/' . $video->file_path) }}" target="_blank" class="btn btn-view btn-sm">
                                <i class="fas fa-file-video"></i> Tonton Video
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-center text-muted">
                        <i class="fas fa-info-circle"></i> Belum ada video yang tersedia.
                    </p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
