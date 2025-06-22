
<div class="comment-item">
    <div class="d-flex">
        <div class="comment-content flex-grow-1">
            <div class="comment-header mb-2">
                <strong class="comment-author">{{ $comment->user->username ?? 'Anonymous' }}</strong>
                <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
            <div class="comment-text">{{ $comment->content }}</div>
        </div>
    </div>
</div>