<x-app-layout>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <h2 class="h4 mb-0">
            <i class="bi bi-heart-fill me-2 text-danger"></i>
            Komik Favorit Saya
        </h2>
    </x-slot>

    <div class="container mt-4">
        <div class="section-container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <h3 class="section-header">
                <i class="bi bi-collection"></i>
                <span>Daftar Komik Favorit Anda</span>
            </h3>

            {{-- Grid untuk menampilkan daftar komik favorit --}}
         <div class="comic-grid" >
    @forelse($favoriteKomiks as $komik)
        <a href="{{ route('komik.show', $komik->id) }}" class="comic-item">
            <img src="{{ $komik->cover_image }}" alt="{{ $komik->judul }}" class="comic-cover">
            <div class="comic-info">
                <div class="comic-title">{{ $komik->judul }}</div>
                <div class="comic-meta">
                    {{-- Menampilkan chapter terakhir dan status, bisa disesuaikan jika perlu --}}
                    <span><i class="bi bi-journal-bookmark-fill"></i> Ch. {{ $komik->latest_chapter ?? 'Baru' }}</span>
                    <span class="ms-2"><i class="bi bi-clock-history"></i> {{ $komik->status }}</span>
                </div>
            </div>
        </a>
    @empty
        {{-- Tampilan ini akan muncul jika tidak ada komik favorit --}}
        <div class="empty-state">
            <p class="text-muted">Anda belum menambahkan komik ke favorit.</p>
        </div>
    @endforelse
</div>
            {{-- Menampilkan link paginasi --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $favoriteKomiks->links() }}
            </div>
        </div>
    </div>

</x-app-layout>