@extends('layout2.app')

@section('konten')

<style>
    .chat-box {
        background-color: #f9f9f9;
    }

    .chat-message {
        margin-bottom: 3px;
    }

    .alert {
        display: inline-block;
        max-width: 80%;
    }

    .text-end .alert {
        float: right;
        clear: both;
    }
</style>
<div class="container mt-4">
    <h3 class="mb-4">Detail Pesan</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <strong>Judul Pesan:</strong> {{ $pesan->judul }}
        </div>
        <div class="card-body">
            <div class="chat-box" style="max-height: 400px; overflow-y: auto; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                <!-- Pesan Utama -->
                <div class="chat-message mb-3">
                    <div class="alert alert-primary">
                        <strong>{{ $pesan->pengirim->username }}:</strong>
                        {{ $pesan->isi_pesan }} <br>
                        <small class="text-muted">Dikirim pada {{ $pesan->created_at->format('d M Y | H:i:s') }}</small>
                    </div>
                </div>

                <!-- Balasan -->
                @if($pesan->balasan && $pesan->balasan->isNotEmpty())
                    @foreach($pesan->balasan as $balasan)
                        <div class="chat-message mb-3 {{ $balasan->pengirim->id == auth()->id() ? 'text-end' : '' }}">
                            <div class="alert {{ $balasan->pengirim->id == auth()->id() ? 'alert-success' : 'alert-secondary' }}">
                                <strong>{{ $balasan->pengirim->username }}:</strong>
                                {{ $balasan->isi }} <br>
                                <small class="text-muted">Dikirim pada {{ $balasan->created_at->format('d M Y | H:i:s') }}</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">Belum ada balasan...</p>
                @endif
            </div>
        </div>
        <div class="card-footer">
            <!-- Form Kirim Balasan -->
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
</div>
@endsection
