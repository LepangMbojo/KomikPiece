{{-- File: resources/views/partials/_comment_item.blade.php --}}
<div class="comment-item">
    <div class="d-flex">
        <div class="comment-avatar me-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? 'A') }}&background=random" class="rounded-circle" width="40" height="40">
        </div>
        <div class="comment-content flex-grow-1">
            <div class="comment-header mb-2">
                <strong class="comment-author">{{ $comment->user->username ?? 'Anonymous' }}</strong>
                <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
            <div class="comment-text">{{ $comment->content }}</div>
        </div>
    </div>
</div>