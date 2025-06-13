<x-app-layout>
   <x-slot name="header">
    <x-page-header
        :title="$komik->judul"
        />
</x-slot>

    <div class="container py-4">
        <div class="section-container">
            <div class="row">
                <div class="col-md-3 text-center mb-4">
                   <img src="{{ $komik->cover_image }}" alt="{{ $komik->title }}" class="comic-cover img-fluid rounded shadow">
                    <div class="mt-3">
                        @auth
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
                    <h1 class="komik-title mb-3 text-white">{{ $komik->title }}</h1>
                    
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
                                    <span class="meta-value text-white">{{ $komik->author }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="meta-item">
                                    <span class="meta-label">Genre:</span>
                                    <span class="meta-value">
                                        @if($komik->genres)
                                            @foreach($komik->genres as $genre)
                                                <a href="{{ route('comics.genre', $genre->slug) }}" class="badge bg-secondary text-decoration-none">
                                                    {{ $genre->name }}
                                                </a>
                                            @endforeach
                                        @endif  
                                        @if($komik->genres->isEmpty())
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
                                        <span class="ms-2 text-white">{{ number_format($komik->rating, 1) }}/5</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="meta-item">
                                    <span class="meta-label">Views:</span>
                                    <span class="meta-value text-white">{{ number_format($komik->views) }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="meta-item">
                                    <span class="meta-label">Updated:</span>
                                    <span class="meta-value text-white">{{ $komik->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="komik-description">
                        <h5 class="text-primary mb-3">Synopsis</h5>
                        <p class="text-white lh-lg">{{ $komik->description }}</p>
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

        <div class="section-container">
            <div class="section-header">
                <i class="bi bi-list-ol"></i>
                <span>Chapters ({{ $komik->chapters->count() }})</span>

            </div>

            <!-- PERBAIKI BAGIAN CHAPTERS LIST -->
<div class="chapters-list" id="chaptersList">
    @forelse($komik->chapters->sortByDesc('chapter_number') as $chapter)
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

    <div class="section-container">
        <div class="section-header">
            <i class="bi bi-chat-dots"></i>
            <span>Comments ({{ $komik->comments->count() }})</span>
        </div>

        @auth
            <div class="comment-form mb-4">
                <form action="{{ route('komik.comments.store', $komik->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea class="form-control bg-dark text-white border-secondary @error('content') is-invalid @enderror" 
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
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <a href="{{ route('login') }}" class="alert-link">Login</a> to post comments.
            </div>
        @endauth

        <div class="comments-list">
            @forelse($komik->comments as $comment)
                @include('partials._comment_item', ['comment' => $comment])
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-chat-left-text display-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">No comments yet</h5>
                    <p class="text-muted">Be the first to leave a comment!</p>
                </div>
            @endforelse
            @if($komik->comments_count > $komik->comments->count())
                <div class="text-center mt-4">
                    <button class="btn btn-outline-light" id="loadMoreBtn" onclick="loadMoreComments()">
                        <i class="bi bi-arrow-down me-2"></i>Load More Comments
                    </button>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>


<script>
   document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('bookmark-btn');
    if (btn) {
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

                if (res.ok || res.status === 204) {
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
                    console.error('Unexpected response:', res.status, await res.text());
                    text.textContent = isBookmarked ? 'Remove from Bookmark' : 'Add to Bookmark';
                    alert('Failed to update bookmark status. Please try again.');
                }

            } catch (err) {
                console.error('Fetch error:', err);
                text.textContent = isBookmarked ? 'Remove from Bookmark' : 'Add to Bookmark';
                alert('An error occurred. Please check your internet connection and try again.');
            } finally {
                btn.disabled = false;
            }
        });
    }
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
                    const loadMoreContainer = document.getElementById('loadMoreBtn') ? document.getElementById('loadMoreBtn').parentElement : null;


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
                                            <small class="text-white-50 ms-2">${comment.created_at}</small>
                                        </div>
                                        <div class="comment-text">${comment.content}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                        if (loadMoreContainer) {
                             loadMoreContainer.insertAdjacentHTML('beforebegin', commentHtml);
                        } else {
                            commentsList.insertAdjacentHTML('beforeend', commentHtml);
                        }
                    });

                    if (data.comments.length < 10) {
                        if (loadMoreContainer) loadMoreContainer.style.display = 'none';
                    } else {
                        if (btn) {
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        }
                    }
                } else {
                    if (btn && btn.parentElement) btn.parentElement.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error loading comments:', error);
                if (btn) {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }

                const errorAlert = `
                    <div class="alert alert-danger alert-dismissible fade show mt-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Failed to load more comments. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                const targetElement = btn ? btn.parentElement : document.querySelector('.comments-list');
                if (targetElement) targetElement.insertAdjacentHTML('afterend', errorAlert);
            });
    }

    function toggleBookmark() {
        const btn = document.querySelector('#bookmark-text');
        const icon = btn.previousElementSibling;

        if (btn.textContent === 'Add to Bookmark') {
            btn.textContent = 'Remove Bookmark';
            icon.className = 'bi bi-bookmark-fill me-2';
        } else {
            btn.textContent = 'Add to Bookmark';
            icon.className = 'bi bi-bookmark me-2';
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