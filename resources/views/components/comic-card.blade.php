<div>
    
<a href="{{ route('komik.show', $komik->id) }}" class="comic-card">
    <img src="{{ $komik->cover_image }}" alt="{{ $komik->judul }}" class="comic-cover">
    <div class="comic-info">
        <h6 class="comic-title">{{ $komik->judul }}</h6>
        <div class="comic-meta">
            <span class="comic-rating">
                <i class="bi bi-star-fill"></i> {{ $komik->rating ?? 0 }}
            </span>
            <span class="comic-chapter">
    Ch. {{ $komik->chapters_max_chapter_number ?? 0 }}
</span>
        </div>
    </div>
</a>
</div>