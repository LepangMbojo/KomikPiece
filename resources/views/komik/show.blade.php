<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $komik->title }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                   <li class="breadcrumb-item"><a href="{{ route('index') }}">Komiks</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $komik->title }}</li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="container py-4">
        <!-- komik Detail Header -->
        <div class="section-container">
            <div class="row">
                <div class="col-md-3 text-center mb-4">
                   <img src="{{ $komik->cover_image }}" alt="{{ $komik->title }}" class="comic-cover img-fluid rounded shadow">
                    <div class="mt-3">
                        @auth
    {{-- Tombol ini sekarang memiliki ID dan atribut data-* untuk dibaca oleh JavaScript --}}
    <button id="bookmark-btn" 
            class="btn w-100 mb-2 {{ $isFavorited ? 'btn-danger' : 'btn-outline-danger' }}"
            data-comic-id="{{ $komik->id }}"
            data-add-url="{{ route('favorites.add', $komik->id) }}"
            data-remove-url="{{ route('favorites.remove', $komik->id) }}">
        
        <i class="bi {{ $isFavorited ? 'bi-bookmark-fill' : 'bi-bookmark' }} me-2"></i>
        <span id="bookmark-text">
            {{ $isFavorited ? 'Remove from Bookmark' : 'Add to Bookmark' }}
        </span>
    </button>
@endauth
                        <button class="btn btn-outline-light w-100" onclick="sharekomik()">
                            <i class="bi bi-share me-2"></i>Share
                        </button>
                    </div>
                </div>
                <div class="col-md-9">
                    <h1 class="komik-title mb-3">{{ $komik->title }}</h1>
                    
                    <div class="komik-meta-grid mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="meta-item">
                                    <span class="meta-label">Status:</span>
                                    <span class="meta-value badge bg-{{ $komik->status == 'ongoing' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($komik->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="meta-item">
                                    <span class="meta-label">Author:</span>
                                    <span class="meta-value">{{ $komik->author }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
    <div class="meta-item">
        <span class="meta-label">Genre:</span>
        <span class="meta-value">
            @if($komik->genre)
                <!-- Jika genre adalah string tunggal -->
                <span class="badge bg-primary">{{ $komik->genre }}</span>
                
                <!-- ATAU jika genre adalah string dengan koma sebagai pemisah -->
                <!-- 
                @foreach(explode(',', $komik->genre) as $genre)
                    <span class="badge bg-dark me-1">{{ trim($genre) }}</span>
                @endforeach
                -->
            @else
                <span class="text-muted">No genre specified</span>
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
                                                <i class="bi bi-star{{ $i <= $komik->rating ? '-fill' : '' }}"></i>
                                            @endfor
                                        </span>
                                        <span class="ms-2">{{ number_format($komik->rating, 1) }}/5</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="meta-item">
                                    <span class="meta-label">Views:</span>
                                    <span class="meta-value">{{ number_format($komik->views) }}</span>
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
                    
                    <div class="komik-description">
                        <h5 class="text-primary mb-3">Synopsis</h5>
                        <p class="text-light lh-lg">{{ $komik->description }}</p>
                    </div>

                    <div class="action-stats mt-4">
                        <div class="row g-2">
                            <div class="col-auto">
                                <span class="badge bg-primary">
                                    <i class="bi bi-eye me-1"></i>{{ number_format($komik->views) }} Views
                                </span>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-warning">
                                    <i class="bi bi-bookmark me-1"></i>{{ $komik->favoredByUsers()->count() }} Bookmarks
                                </span>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-info">
                                    <i class="bi bi-chat me-1"></i>{{ number_format($komik->comments_count) }} Comments
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
                <span>Chapters ({{ $komik->chapters->count() }})</span>
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

            <!-- PERBAIKI BAGIAN CHAPTERS LIST -->
<div class="chapters-list" id="chaptersList">
    @forelse($komik->chapters ?? [] as $chapter)
        <div class="chapter-item">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <!-- PASTIKAN LINK INI BENAR -->
                    <a href="{{ route('komik.chapter', [$komik->id, $chapter->chapter_number]) }}" 
                       class="chapter-link text-decoration-none">
                        <h6 class="chapter-title mb-1">
                            Chapter {{ $chapter->chapter_number }}
                            @if($chapter->title)
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
                    @if($chapter->is_new ?? false)
                        <span class="badge bg-danger me-2">NEW</span>
                    @endif
                    <!-- PASTIKAN LINK INI JUGA BENAR -->
                    <a href="{{ route('komik.chapter', [$komik->id, $chapter->chapter_number]) }}" 
                       class="btn btn-primary btn-sm">
                        <i class="bi bi-play-fill me-1"></i>Read
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="bi bi-book display-1 text-muted"></i>
            <h5 class="mt-3 text-muted">No chapters available yet</h5>
            <p class="text-muted">Check back later for new chapters!</p>
        </div>
    @endforelse
</div>

            @if($komik->chapters->count() > 10)
                <div class="text-center mt-4">
                    <button class="btn btn-outline-light" onclick="loadMoreChapters()">
                        <i class="bi bi-arrow-down me-2"></i>Load More Chapters
                    </button>
                </div>
            @endif
        </div>


Related Comics
@if($relatedkomiks->count() > 0)
    <div class="section-container">
        <div class="section-header">
            <i class="bi bi-collection"></i>
            <span>Related Comics</span>
        </div>

        <div class="comic-grid">
            @foreach($relatedkomiks as $related)
                <div class="comic-item" onclick="location.href='{{ route('komik.show', $related->id) }}'">
                   <img src="{{ $komik->cover_image }}" alt="{{ $komik->title }}" class="comic-cover img-fluid rounded shadow"
                         alt="{{ $related->judul }}" 
                         class="comic-cover">
                    <div class="comic-info">
                        <h6 class="comic-title">{{ $related->judul }}</h6>
                        <div class="comic-meta">
                            <span class="comic-rating">
                                <i class="bi bi-star-fill"></i> {{ number_format($related->rating ?? 0, 1) }}
                            </span>
                            <span class="comic-chapter">Ch. {{ $related->latest_chapter }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

{{-- GANTI SELURUH BAGIAN KOMENTAR ANDA DENGAN INI --}}

<div class="section-container">
    <div class="section-header">
        <i class="bi bi-chat-dots"></i>
        {{-- Menampilkan jumlah komentar dari koleksi yang sudah di-load --}}
        <span>Comments ({{ $komik->comments->count() }})</span>
    </div>

    {{-- Form untuk user yang sudah login --}}
    @auth
        <div class="comment-form mb-4">
            <form action="{{ route('komik.comments.store', $komik->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <textarea class="form-control @error('content') is-invalid @enderror" 
                              id="content" name="content" rows="3" 
                              placeholder="Share your thoughts about this comic..." 
                              required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-2"></i>Post Comment
                    </button>
                </div>
            </form>
        </div>
    @else
        {{-- Pesan untuk user yang belum login --}}
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            <a href="{{ route('login') }}" class="alert-link">Login</a> to post comments.
        </div>
    @endauth

    {{-- Daftar Komentar --}}
    <div class="comments-list">
        {{-- Gunakan @forelse untuk menangani kasus jika tidak ada komentar --}}
        @forelse($komik->comments as $comment)
            <div class="comment-item">
                <div class="d-flex">
                    <div class="comment-avatar me-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=random" class="rounded-circle" width="40" height="40">
                    </div>
                    <div class="comment-content flex-grow-1">
                        <div class="comment-header mb-2">
                            <strong class="comment-author">
                                {{-- Menampilkan nama user dari relasi --}}
                                {{ $comment->user->name ?? 'Anonymous' }}
                            </strong>
                            <small class="text-muted ms-2">
                                {{ $comment->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <div class="comment-text">
                            {{ $comment->content }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- Tampilan ini akan muncul jika $komik->comments kosong --}}
            <div class="text-center py-4">
                <p class="text-muted">No comments yet. Be the first to share your thoughts!</p>
            </div>
        @endforelse
    </div>
</div>
<!-- STYLE -->
<style>
    :root {
        --card-bg: #1e1e1e;
        --primary-color: #ff5722;
        --dark-color: #121212;
    }

    .komik-cover {
        width: 100%;
        max-width: 250px;
        height: 350px;
        object-fit: cover;
        border: 2px solid #444;
    }

    .meta-item, .chapter-item, .comment-form, .comment-item {
        background-color: var(--card-bg);
        border: 1px solid #444;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .meta-label {
        color: #aaa;
        font-weight: 600;
        display: block;
        margin-bottom: 5px;
    }

    .meta-value, .chapter-title {
        color: #fff;
        font-weight: 500;
    }

    .chapter-link {
        color: inherit;
    }

    .chapter-link:hover .chapter-title {
        color: var(--primary-color);
    }

    .comment-author {
        color: var(--primary-color);
        font-weight: 600;
    }

    .comment-text {
        color: #ccc;
        line-height: 1.6;
        word-wrap: break-word;
        white-space: pre-wrap;
    }

    .comment-avatar {
        flex-shrink: 0;
    }

    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--dark-color);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #444;
    }

    .comment-header {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 8px;
    }

    .comments-list {
        max-height: 600px;
        overflow-y: auto;
    }

    .comments-list::-webkit-scrollbar {
        width: 6px;
    }

    .comments-list::-webkit-scrollbar-thumb {
        background: #444;
        border-radius: 3px;
    }

    .comments-list::-webkit-scrollbar-thumb:hover {
        background: var(--primary-color);
    }

    .comment-item:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 87, 34, 0.1);
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) {
        .komik-cover {
            max-width: 200px;
            height: 280px;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .comment-avatar {
            display: none;
        }

        .comment-form {
            padding: 15px;
        }
    }
</style>

<!-- SCRIPT -->
<script>
   // Menambahkan event listener ke tombol setelah halaman dimuat
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('bookmark-btn');
    if (!btn) return;

    btn.addEventListener('click', async () => {
        const text = document.getElementById('bookmark-text');
        const icon = btn.querySelector('i');
        const isBookmarked = text.textContent.trim() === 'Remove from Bookmark';
        const url = isBookmarked ? btn.dataset.removeUrl : btn.dataset.addUrl;
        const method = isBookmarked ? 'DELETE' : 'POST';

        btn.disabled = true;
        text.textContent = 'Loading...';

        try {
            const res = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            // Lanjutkan jika respons sukses (204 atau 200)
            if (res.status === 200 || res.status === 204) {
                if (isBookmarked) {
                    text.textContent = 'Add to Bookmark';
                    icon.className = 'bi bi-bookmark me-2';
                    btn.classList.replace('btn-danger', 'btn-outline-danger');
                } else {
                    text.textContent = 'Remove from Bookmark';
                    icon.className = 'bi bi-bookmark-fill me-2';
                    btn.classList.replace('btn-outline-danger', 'btn-danger');
                }
            } else {
                console.error('Unexpected response:', res.status);
                text.textContent = isBookmarked ? 'Remove from Bookmark' : 'Add to Bookmark';
            }

        } catch (err) {
            console.error('Fetch error:', err);
            text.textContent = isBookmarked ? 'Remove from Bookmark' : 'Add to Bookmark';
        } finally {
            btn.disabled = false;
        }
    });
});



    function loadMoreComments() {
        const btn = document.getElementById('loadMoreBtn');
        const originalText = btn.innerHTML;

        btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Loading...';
        btn.disabled = true;

        const comicId = {{ Js::from($komik->id) }};
        const currentCount = document.querySelectorAll('.comment-item').length;

        fetch(`/komik/${comicId}/comments/load-more?offset=${currentCount}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.comments && data.comments.length > 0) {
                    const commentsList = document.querySelector('.comments-list');
                    const loadMoreContainer = btn.parentElement;

                    data.comments.forEach(comment => {
                        const commentHtml = `
                            <div class="comment-item">
                                <div class="d-flex">
                                    <div class="comment-avatar me-3">
                                        <div class="avatar-circle">
                                            <i class="bi bi-person-circle fs-2 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="comment-content flex-grow-1">
                                        <div class="comment-header mb-2">
                                            <strong class="comment-author">${comment.user.name}</strong>
                                            <small class="text-muted ms-2">${comment.created_at}</small>
                                        </div>
                                        <div class="comment-text">${comment.content}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                        loadMoreContainer.insertAdjacentHTML('beforebegin', commentHtml);
                    });

                    if (data.comments.length < 10) {
                        loadMoreContainer.style.display = 'none';
                    } else {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                } else {
                    btn.parentElement.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error loading comments:', error);
                btn.innerHTML = originalText;
                btn.disabled = false;

                const errorAlert = `
                    <div class="alert alert-danger alert-dismissible fade show mt-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Failed to load more comments. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                btn.parentElement.insertAdjacentHTML('afterend', errorAlert);
            });
    }

    function toggleBookmark() {
        const btn = document.querySelector('#bookmark-text');
        const icon = btn.previousElementSibling;

        if (btn.textContent === 'Add to Bookmark') {
            btn.textContent = 'Remove Bookmark';
            icon.className = 'bi bi-bookmark-fill me-2';
            // AJAX call here
        } else {
            btn.textContent = 'Add to Bookmark';
            icon.className = 'bi bi-bookmark me-2';
            // AJAX call here
        }
    }

    function sharekomik() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $komik->title }}',
                text: 'Check out this amazing komik!',
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href);
            alert('Link copied to clipboard!');
        }
    }

    function sortChapters(order) {
        console.log('Sorting chapters:', order);
    }

    function loadMoreChapters() {
        console.log('Loading more chapters...');
    }
</script>

</x-app-layout>