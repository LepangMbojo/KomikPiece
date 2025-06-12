<div>
    <!-- People find pleasure in different ways. I find it in keeping my mind clear. - Marcus Aurelius -->{{-- File: resources/views/components/genre-card.blade.php --}}

@props(['genre', 'icon' => 'bi-tag-fill']) {{-- Menerima genre, dan ikon default --}}

<a href="{{ route('comics.by.genre', $genre->slug) }}" class="genre-card text-decoration-none">
    <i class="bi {{ $icon }} genre-icon"></i>
    <div class="genre-name">{{ $genre->name }}</div>
    {{-- Gunakan 'komiks_count' yang dibuat otomatis oleh withCount() --}}
    <div class="genre-count">{{ $genre->komiks_count }} komik</div>
</a>
</div>