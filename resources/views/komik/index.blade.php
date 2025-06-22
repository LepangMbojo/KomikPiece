<x-app-layout>


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
        <x-comic-card :komik="$komik" />
    @empty
        <div class="text-center py-5">
            <i class="bi bi-book display-1 text-muted"></i>
            <h5 class="mt-3 text-muted">Belum ada komik</h5>
            <p class="text-muted">Belum ada komik yang tersedia</p>
        </div>
    @endforelse
</div>

           
    <div class="d-flex justify-content-center mt-4">
        {{ $komiks->links() }}
    </div>

</x-app-layout>
