<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Hasil Pencarian: "{{ $query }}"</h2>
    </x-slot>

    <div class="container py-4">
        <div class="section-container">
            <div class="section-header">
                <i class="bi bi-search"></i>
                <span>Ditemukan {{ $komiks->total() }} komik</span>
            </div>

            <div class="comic-grid">
                @forelse($komiks as $komik)
                    <div class="comic-item" onclick="location.href='{{ route('komik.show', $komik->id) }}'">
                        <img src="{{ $komik->cover_image }}" 
     alt="{{ $komik->judul }}" 
     class="comic-cover">
                        
                        <div class="comic-info">
                            <h6 class="comic-title">{{ $komik->judul }}</h6>
                            <div class="comic-meta">
                                <span class="comic-rating">
                                    <i class="bi bi-star-fill"></i> {{ $komik->rating ?? 0 }}
                                </span>
                                <span class="comic-chapter">Ch. {{ $komik->chapter ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-search display-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">Tidak ada hasil</h5>
                        <p class="text-muted">Coba kata kunci yang berbeda</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($komiks->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $komiks->appends(['q' => $query])->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>