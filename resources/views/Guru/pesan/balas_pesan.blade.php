@extends('layout2.app')

@section('konten')

<style>
    .chat-box {
        background-color: #f5f7fa;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        max-height: 400px;
        overflow-y: auto;
    }

    .chat-message {
        margin-bottom: 20px;
        display: flex;
    }

    .chat-message .alert {
        max-width: 70%;
        word-wrap: break-word;
        border-radius: 20px;
        padding: 10px 15px;
        font-size: 0.9rem;
    }

    .chat-message.user {
        justify-content: flex-end;
    }

    .chat-message .user-alert {
        background-color: #cdffd1; /* Biru pastel */
        color: #333;
    }

    .chat-message .other-alert {
        background-color: #fed9f8; /* Kuning pastel */
        color: #333;
    }

    .chat-message small {
        display: block;
        margin-top: 5px;
        font-size: 0.8rem;
        color: #729e7a;
    }

    .form-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #ddd;
        padding: 15px;
        border-radius: 0 0 8px 8px;
    }

    .btn-primary {
        background-color: blue; /* Hijau pastel */
        border: none;
    }

    .btn-primary:hover {
        background-color: blue;
    }

    .back-button {
        margin-top: 20px;
        display: inline-block;
        font-size: 0.9rem;
        font-weight: bold;
        color: blue;
        text-decoration: none;
        transition: color 0.3s;
    }

    .back-button:hover {
        color: blue;
        text-decoration: underline;
    }
</style>

<div class="container mt-4">
    <h3 class="text-center mb-4 text-primary">Detail Pesan</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><strong>Judul Pesan:</strong> {{ $pesan->judul }}</h5>
        </div>
        <div class="card-body">
            <div class="chat-box">
                <!-- Pesan Utama -->
                <div class="chat-message">
                    <div class="alert other-alert">
                        <strong>{{ $pesan->pengirim->username }}:</strong>
                        {{ $pesan->isi_pesan }}
                        <small>Dikirim pada {{ $pesan->created_at->format('d M Y | H:i:s') }}</small>
                    </div>
                </div>

                <!-- Balasan -->
                @if($pesan->balasan && $pesan->balasan->isNotEmpty())
                    @foreach($pesan->balasan as $balasan)
                        <div class="chat-message {{ $balasan->pengirim->id == auth()->id() ? 'user' : '' }}">
                            <div class="alert {{ $balasan->pengirim->id == auth()->id() ? 'user-alert' : 'other-alert' }}">
                                <strong>{{ $balasan->pengirim->username }}:</strong>
                                {{ $balasan->isi }}
                                <small>Dikirim pada {{ $balasan->created_at->format('d M Y | H:i:s') }}</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">Belum ada balasan...</p>
                @endif
            </div>
        </div>
        <div class="form-footer">
            <form action="{{ route('pesan.reply', $pesan->id) }}" method="POST">
                @csrf
                <div class="input-group">
                    <textarea name="isi" class="form-control" placeholder="Ketik pesan Anda di sini..." required></textarea>
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-paper-plane"></i> Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
    <a href="{{ route('guru.pesan.index') }}" class="back-button">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesan
    </a>
</div>
@endsection
