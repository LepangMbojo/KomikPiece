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

           
         <div class="comic-grid" >
    @forelse($favoriteKomiks as $komik)
        <x-comic-card :komik="$komik" />
    @empty
   
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