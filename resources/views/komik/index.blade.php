<x-app-layout>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            @if(isset($isDashboard) && $isDashboard)
                <h2 class="h4 mb-0">Dashboard - Selamat Datang, {{ $user->username }}!</h2>
            @else
                <h2 class="h4 mb-0">Daftar Komik</h2>
            @endif
        </div>
    </x-slot>

    <div class="container py-4">
        @if(isset($isDashboard) && $isDashboard)
            <!-- Welcome message untuk dashboard -->
            <div class="section-container mb-4">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Selamat datang kembali, {{ $user->username }}! Lanjutkan petualangan membaca komikmu.
                </div>
            </div>
        @endif

        <!-- Rest of the content sama seperti index.blade.php -->
        <!-- ... -->


    <div class="container mt-4">
        <!-- Popular Now Section with Dark Background -->
        <div class="section-container section-spacing">
            <div class="section-header">
                <i class="bi bi-fire"></i>
                Popular Now
            </div>

            <div class="comic-grid" id="popularGrid">
                <!-- Popular comics will be loaded here -->
            </div>
        </div>

        <!-- New Uploads Section with Dark Background -->
        <div class="section-container">
            <div class="section-header">
                <i class="bi bi-clock-history"></i>
                <span>Komik Terbaru</span>
            </div>

            <div class="comic-grid">
               @forelse($komiks as $comic)
    <div class="comic-item" onclick="location.href='{{ url('/komik/' . $comic->id) }}'">
        <img src="{{ asset('storage/' . $comic->cover) }}" 
             alt="{{ $comic->judul }}" 
             class="comic-cover">
        
        <div class="comic-info">
            <h6 class="comic-title">{{ $comic->judul }}</h6>
            <div class="comic-meta">
                <span class="comic-rating">
                    <i class="bi bi-star-fill"></i> {{ $comic->rating ?? 0 }}
                </span>
                <span class="comic-chapter">Ch. {{ $comic->chapter ?? 0 }}</span>
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-5">
        <i class="bi bi-book display-1 text-muted"></i>
        <h5 class="mt-3 text-muted">Belum ada komik</h5>
        <p class="text-muted">Belum ada komik yang tersedia</p>
    </div>
@endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $komiks->links() }}
            </div>
        </div>
        <!-- Load More -->
        <div class="load-more">
            <button class="btn-load-more" onclick="loadMoreComics()">
                Load More
            </button>
        </div>
    </div>

    <script>
        // Sample comic data
    
        function loadComics() {
            const popularGrid = document.getElementById('popularGrid');
            const newUploadsGrid = document.getElementById('newUploadsGrid');
            
            popularGrid.innerHTML = popularComics.map(createComicItem).join('');
            newUploadsGrid.innerHTML = newUploads.map(createComicItem).join('');
        }

        function openComic(comicId) {
            alert(`Membuka komik dengan ID: ${comicId}`);
        }

        function loadMoreComics() {
            const button = event.target;
            const originalText = button.textContent;
            
            button.textContent = 'Loading...';
            button.disabled = true;
            
            setTimeout(() => {
                // Simulate loading more comics
                alert('Memuat lebih banyak komik...');
                button.textContent = originalText;
                button.disabled = false;
            }, 1500);
        }

        // Load comics on page load
        document.addEventListener('DOMContentLoaded', loadComics);
    </script>
</x-app-layout>
