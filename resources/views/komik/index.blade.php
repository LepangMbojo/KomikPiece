<x-app-layout>


    
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
       @forelse($popularKomiks as $komik)
        <x-comic-card :komik="$komik" />
    @empty
        <div class="empty-state">
            <p class="text-muted">Belum ada komik populer saat ini.</p>
        </div>
    @endforelse
        </div>
    </div>



        <!-- New Uploads Section with Dark Background -->
        <div class="section-container">
            <div class="section-header">
                <i class="bi bi-clock-history"></i>
                <span>Komik Terbaru</span>
            </div>

    <div class="comic-grid">
    @forelse($komiks as $komik)
        {{-- 
          Memanggil komponen 'comic-card' dan mengirim data dari variabel $komik 
          ke dalam komponen tersebut melalui prop :komik
        --}}
        <x-comic-card :komik="$komik" />
    @empty
        <div class="text-center py-5">
            <i class="bi bi-book display-1 text-muted"></i>
            <h5 class="mt-3 text-muted">Belum ada komik</h5>
            <p class="text-muted">Belum ada komik yang tersedia</p>
        </div>
    @endforelse
</div>

            <!-- Pagination -->
            @if(!isset($isDashboard) || !$isDashboard)
    <div class="d-flex justify-content-center mt-4">
        {{ $komiks->links() }}
    </div>
@endif
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
