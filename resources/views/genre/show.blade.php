<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $genre->name }} Comics</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('genre.index') }}">Genres</a></li>
                    <li class="breadcrumb-item active">{{ $genre->name }}</li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="section-container">
            @if($genre->description)
                <div class="genre-description mb-4">
                    <p class="text-light">{{ $genre->description }}</p>
                </div>
            @endif

            <div class="comic-grid">
                @forelse($komiks as $komik)
                    <div class="comic-item" onclick="location.href='{{ route('comics.show', $komik->id) }}'">
                        <img src="{{ $komik->cover_image }}" alt="{{ $komik->title }}" class="comic-cover">
                        <div class="comic-info">
                            <h6 class="comic-title">{{ $komik->title }}</h6>
                            <div class="comic-meta">
                                <span class="comic-rating">
                                    <i class="bi bi-star-fill"></i> {{ number_format($komik->rating ?? 0, 1) }}
                                </span>
                                <span class="comic-status">{{ ucfirst($komik->status) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-book display-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">No comics found in this genre</h5>
                    </div>
                @endforelse
            </div>

            {{ $komiks->links() }}
        </div>
    </div>
</x-app-layout>