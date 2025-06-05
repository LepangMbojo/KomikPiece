<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">Dashboard - Selamat Datang, {{ $user->username }}!</h2>
        </div>
    </x-slot>

    <div class="container py-4">
        <!-- Welcome Section -->
        <div class="section-container mb-4">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="text-primary mb-3">
                        <i class="bi bi-person-circle me-2"></i>
                        Selamat Datang Kembali, {{ $user->username }}!
                    </h3>
                    <p class="text-light">Lanjutkan petualangan membaca komik favoritmu.</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-flex gap-2 justify-content-end">
                        <div class="badge bg-primary p-2">
                            <i class="bi bi-bookmark me-1"></i>
                            {{ count($bookmarkedComics) }} Bookmarks
                        </div>
                        <div class="badge bg-success p-2">
                            <i class="bi bi-clock-history me-1"></i>
                            {{ count($recentlyRead) }} Recently Read
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="section-container mb-4">
            <div class="section-header">
                <i class="bi bi-lightning"></i>
                <span>Quick Actions</span>
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <a href="{{ url('/') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-house me-2"></i>Browse All Comics
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#" class="btn btn-outline-success w-100">
                        <i class="bi bi-bookmark me-2"></i>My Bookmarks
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#" class="btn btn-outline-info w-100">
                        <i class="bi bi-clock-history me-2"></i>Reading History
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#" class="btn btn-outline-warning w-100">
                        <i class="bi bi-gear me-2"></i>Settings
                    </a>
                </div>
            </div>
        </div>

        <!-- Recently Read Comics (if any) -->
        @if(count($recentlyRead) > 0)
            <div class="section-container mb-4">
                <div class="section-header">
                    <i class="bi bi-clock-history"></i>
                    <span>Continue Reading</span>
                </div>
                <div class="comic-grid">
                    @foreach($recentlyRead as $comic)
                        <div class="comic-item" onclick="location.href='{{ url('/komik/' . $comic->id) }}'">
                            <img src="{{ asset('storage/' . $comic->cover_path) }}" alt="{{ $comic->judul }}" class="comic-cover">
                            <div class="comic-info">
                                <h6 class="comic-title">{{ $comic->judul }}</h6>
                                <div class="comic-meta">
                                    <span class="comic-rating">
                                        <i class="bi bi-star-fill"></i> {{ number_format($comic->rating ?? 4, 1) }}
                                    </span>
                                    <span class="comic-chapter">Continue</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Search Bar -->
        <div class="section-container mb-4">
            <form action="{{ url('/search') }}" method="GET" class="row g-3">
                <div class="col-md-10">
                    <input type="text" name="q" class="form-control search-input" 
                           placeholder="Cari komik favoritmu..." value="{{ request('q') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Latest Comics -->
        <div class="section-container">
            <div class="section-header">
                <i class="bi bi-clock-history"></i>
                <span>Komik Terbaru</span>
                <div class="ms-auto">
                    <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-arrow-right me-1"></i>Lihat Semua
                    </a>
                </div>
            </div>

            <div class="comic-grid">
                @forelse($komiks as $komik)
                    <div class="comic-item" onclick="location.href='{{ url('/komik/' . $komik->id) }}'">
                     <img src="{{ Storage::url($komik->cover) }}" alt="{{ $komik->judul }}">
                        <div class="comic-info">
                            <h6 class="comic-title">{{ $komik->judul }}</h6>
                            <div class="comic-meta">
                                <span class="comic-rating">
                                    <i class="bi bi-star-fill"></i> {{ number_format($komik->rating ?? 4, 1) }}
                                </span>
                                <span class="comic-chapter">
                                    @if(isset($komik->latest_chapter))
                                        Ch. {{ $komik->latest_chapter }}
                                    @else
                                        New
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-emoji-frown display-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">Belum ada komik</h5>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $komiks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>