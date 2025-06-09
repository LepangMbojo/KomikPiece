<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">
                <i class="bi bi-tag-fill me-2 text-primary"></i>
                Komik Genre: {{ $genre->name }}
            </h2>
            <a href="{{ route('index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="section-container">
            <div class="comics-grid">
                @forelse($komiks as $komik)
                    <a href="{{ route('komik.show', $komik->id) }}" class="comic-card">
                        <img src="{{ $komik->cover_image }}" alt="{{ $komik->judul }}" class="comic-cover">
                        <div class="comic-info">
                            <div class="comic-title">{{ $komik->judul }}</div>
                            <div class="comic-meta">Ch. {{ $komik->latest_chapter ?? 'Baru' }}</div>
                        </div>
                    </a>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-book"></i>
                        <h4>Belum Ada Komik</h4>
                        <p>Tidak ada komik yang ditemukan untuk genre ini.</p>
                    </div>
                @endforelse
            </div>

            {{-- Menampilkan link paginasi --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $komiks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>