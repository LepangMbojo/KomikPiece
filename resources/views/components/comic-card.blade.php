<div>
    {{-- File: resources/views/components/comic-card.blade.php --}}

{{-- Mendefinisikan bahwa komponen ini menerima sebuah variabel/objek bernama 'komik' --}}
@props(['komik'])

<a href="{{ route('komik.show', $komik->id) }}" class="comic-card">
    {{-- Memanggil gambar menggunakan accessor yang andal --}}
    <img src="{{ $komik->cover_image }}" alt="{{ $komik->judul }}" class="comic-cover">
    
    <div class="comic-info">
        <h6 class="comic-title">{{ $komik->judul }}</h6>
        <div class="comic-meta">
            <span class="comic-rating">
                <i class="bi bi-star-fill"></i> {{ $komik->rating ?? 0 }}
            </span>
            <span class="comic-chapter">
                Ch. {{ $komik->chapters_count ?? 'Baru' }}
            </span>
        </div>
    </div>
</a>
</div>