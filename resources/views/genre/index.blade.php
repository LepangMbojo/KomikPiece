<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">All Genres</h2>
    </x-slot>

    <div class="container py-4">
        <div class="section-container">
            <div class="section-header">
                <i class="bi bi-tags"></i>
                <span>Browse by Genre</span>
            </div>

            <div class="row g-3">
                @foreach($genres as $genre)
                    <div class="col-md-4 col-lg-3">
                        <div class="genre-card">
                            <a href="{{ route('comics.genre', $genre->slug) }}" class="text-decoration-none">
                                <div class="genre-info">
                                    <h5 class="genre-name">{{ $genre->name }}</h5>
                                    <p class="genre-count">{{ $genre->komiks_count }} Comics</p>
                                    @if($genre->description)
                                        <p class="genre-description">{{ Str::limit($genre->description, 100) }}</p>
                                    @endif
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</x-app-layout>