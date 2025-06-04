<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $komik->judul }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $komik->judul }}</li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="container py-4">
        <!-- Comic Detail Header -->
        <div class="section-container">
            <div class="row">
                <div class="col-md-3 text-center mb-4">
                    <img src="{{ asset('storage/' . $komik->cover_path) }}" alt="{{ $komik->judul }}" class="comic-cover img-fluid rounded shadow">
                    <div class="mt-3">
                        <button class="btn btn-primary w-100 mb-2" onclick="toggleBookmark()">
                            <i class="bi bi-bookmark me-2"></i>
                            <span id="bookmark-text">Add to Bookmark</span>
                        </button>
                        <button class="btn btn-outline-light w-100" onclick="shareComic()">
                            <i class="bi bi-share me-2"></i>Share
                        </button>
                    </div>
                </div>
                <div class="col-md-9">
                    <h1 class="comic-title mb-3">{{ $komik->judul }}</h1>
                    
                    <div class="comic-meta-grid mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="meta-item">
                                    <span class="meta-label">Status:</span>
                                    <span class="meta-value badge bg-{{ $komik->status == 'ongoing' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($komik->status ?? 'Ongoing') }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="meta-item">
                                    <span class="meta-label">Author:</span>
                                    <span class="meta-value">{{ $komik->author ?? 'Unknown' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="meta-item">
                                    <span class="meta-label">Genre:</span>
                                    <span class="meta-value">
                                        @if(isset($komik->genre))
                                            <span class="badge bg-dark text-decoration-none me-1">
                                                {{ $komik->genre }}
                                            </span>
                                        @else
                                            <span class="badge bg-dark text-decoration-none me-1">
                                                Action
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="meta-item">
                                    <span class="meta-label">Rating:</span>
                                    <span class="meta-value">
                                        <span class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= ($komik->rating ?? 4) ? '-fill' : '' }}"></i>
                                            @endfor
                                        </span>
                                        <span class="ms-2">{{ number_format($komik->rating ?? 4, 1) }}/5</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="meta-item">
                                    <span class="meta-label">Views:</span>
                                    <span class="meta-value">{{ number_format($komik->views ?? 0) }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="meta-item">
                                    <span class="meta-label">Updated:</span>
                                    <span class="meta-value">{{ $komik->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="comic-description">
                        <h5 class="text-primary mb-3">Synopsis</h5>
                        <p class="text-light lh-lg">{{ $komik->deskripsi ?? 'No description available.' }}</p>
                    </div>

                    <div class="action-stats mt-4">
                        <div class="row g-2">
                            <div class="col-auto">
                                <span class="badge bg-primary">
                                    <i class="bi bi-eye me-1"></i>{{ number_format($komik->views ?? 0) }} Views
                                </span>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-warning">
                                    <i class="bi bi-bookmark me-1"></i>{{ number_format($komik->bookmarks_count ?? 0) }} Bookmarks
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chapters List -->
        <div class="section-container">
            <div class="section-header">
                <i class="bi bi-list-ol"></i>
                <span>Chapters</span>
                <div class="ms-auto">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-light btn-sm" onclick="sortChapters('asc')">
                            <i class="bi bi-sort-numeric-down"></i> Oldest First
                        </button>
                        <button type="button" class="btn btn-outline-light btn-sm active" onclick="sortChapters('desc')">
                            <i class="bi bi-sort-numeric-up"></i> Newest First
                        </button>
                    </div>
                </div>
            </div>

            <div class="chapters-list" id="chaptersList">
                @if(isset($komik->chapters) && count($komik->chapters) > 0)
                    @foreach($komik->chapters as $chapter)
                        <div class="chapter-item">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <a href="{{ url('/komik/' . $komik->id . '/chapter/' . $chapter->chapter_number) }}" 
                                       class="chapter-link text-decoration-none">
                                        <h6 class="chapter-title mb-1">
                                            Chapter {{ $chapter->chapter_number }}
                                            @if(isset($chapter->title))
                                                : {{ $chapter->title }}
                                            @endif
                                        </h6>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar me-1"></i>{{ $chapter->created_at->format('M d, Y') }}
                                            <i class="bi bi-eye ms-3 me-1"></i>{{ number_format($chapter->views ?? 0) }} views
                                        </small>
                                    </a>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="{{ url('/komik/' . $komik->id . '/chapter/' . $chapter->chapter_number) }}" 
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-play-fill me-1"></i>Read
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-book display-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">No chapters available yet</h5>
                        <p class="text-muted">Check back later for new chapters!</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Related Comics -->
        <div class="section-container">
            <div class="section-header">
                <i class="bi bi-collection"></i>
                <span>Related Comics</span>
            </div>

            <div class="comic-grid">
                @for($i = 0; $i < 6; $i++)
                    <div class="comic-item" onclick="location.href='{{ url('/komik/' . ($i+1)) }}'">
                        <img src="{{ asset('storage/covers/placeholder.jpg') }}" alt="Related Comic" class="comic-cover">
                        <div class="comic-info">
                            <h6 class="comic-title">Related Comic Title {{ $i+1 }}</h6>
                            <div class="comic-meta">
                                <span class="comic-rating">
                                    <i class="bi bi-star-fill"></i> 4.5
                                </span>
                                <span class="comic-chapter">Ch. 10</span>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <style>
        .comic-cover {
            width: 100%;
            max-width: 250px;
            height: 350px;
            object-fit: cover;
            border: 2px solid #444;
        }

        .meta-item {
            background-color: var(--card-bg);
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #444;
        }

        .meta-label {
            color: #aaa;
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
        }

        .meta-value {
            color: #ffffff;
            font-weight: 500;
        }

        .chapter-item {
            background-color: var(--card-bg);
            border: 1px solid #444;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.3s;
        }

        .chapter-item:hover {
            border-color: var(--primary-color);
            transform: translateX(5px);
        }

        .chapter-link {
            color: inherit;
        }

        .chapter-title {
            color: #ffffff;
            margin-bottom: 5px;
        }

        .chapter-link:hover .chapter-title {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .comic-cover {
                max-width: 200px;
                height: 280px;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .section-header .ms-auto {
                margin-left: 0 !important;
            }
        }
    </style>

    <script>
        function toggleBookmark() {
            const btn = document.querySelector('#bookmark-text');
            const icon = btn.previousElementSibling;
            
            if (btn.textContent === 'Add to Bookmark') {
                btn.textContent = 'Remove Bookmark';
                icon.className = 'bi bi-bookmark-fill me-2';
                // Add AJAX call to add bookmark
            } else {
                btn.textContent = 'Add to Bookmark';
                icon.className = 'bi bi-bookmark me-2';
                // Add AJAX call to remove bookmark
            }
        }

        function shareComic() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $komik->judul }}',
                    text: 'Check out this amazing comic!',
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href);
                alert('Link copied to clipboard!');
            }
        }

        function sortChapters(order) {
            // Add AJAX call to sort chapters
            console.log('Sorting chapters:', order);
        }
    </script>
</x-app-layout>