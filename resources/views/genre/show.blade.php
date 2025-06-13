<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">
                <i class="bi bi-tag-fill me-2 text-primary"></i>
                Komik Genre: {{ $genre->name }}
            </h2>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="section-container">
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

            {{-- Menampilkan link paginasi --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $komiks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>