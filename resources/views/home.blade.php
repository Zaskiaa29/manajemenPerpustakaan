@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Koleksi Buku Kami 📚</h2>
        <a href="{{ route('books.index') }}" class="btn btn-outline-primary">Lihat Mode Tabel</a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        @forelse($books as $book)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    @if($book->cover)
                        <img src="{{ asset($book->cover) }}" class="card-img-top" alt="Cover Buku" style="height: 350px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white" style="height: 350px;">
                            <span>Tidak ada gambar</span>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $book->judul }}</h5>
                        <p class="card-text text-muted mb-1"><small>✍️ {{ $book->penulis }}</small></p>
                        <p class="card-text text-muted mb-3"><small>📅 Tahun: {{ $book->tahun_terbit }}</small></p>
                        
                        <div class="mt-auto">
                            @if($book->stok > 0)
                                <span class="badge bg-success w-100 py-2">Stok Tersedia: {{ $book->stok }}</span>
                            @else
                                <span class="badge bg-danger w-100 py-2">Stok Habis</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">Belum ada buku yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection