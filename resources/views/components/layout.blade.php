<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solo Leveling - Chapter 180 | KomikKu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FF5722;
            --dark-color: #1a1a1a;
            --darker-color: #0d0d0d;
            --card-bg: #2a2a2a;
            --section-bg: #1e1e1e;
        }
        
        body {
            background-color: var(--darker-color);
            color: #ffffff;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
     
        /* Comic Info Header */
        .comic-header {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 30px;
            margin: 20px 0;
            border: 1px solid #333;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .comic-cover {
            width: 200px;
            height: 280px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #444;
        }
        
        .comic-title {
            font-size: 2rem;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 10px;
        }
        
        .comic-subtitle {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .comic-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .meta-item {
            background-color: var(--card-bg);
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
            border: 1px solid #444;
        }
        
        .meta-label {
            color: #aaa;
            margin-right: 5px;
        }
        
        .meta-value {
            color: #ffffff;
            font-weight: 600;
        }
        
        .comic-description {
            color: #ccc;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .btn-action {
            padding: 10px 15px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-favorite {
            background-color: #e91e63;
            color: white;
        }

        .btn-favorite:hover {
            background-color: #c2185b;
        }

        .btn-views {
            background-color: #2196f3;
            color: white;
            cursor: default;
        }

        .btn-rating {
            background-color: #ff9800;
            color: white;
            cursor: default;
        }
        
        /* Chapter Navigation */
        .chapter-nav {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #333;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .chapter-nav h5 {
            color: var(--primary-color);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .chapter-nav h5 i {
            margin-right: 10px;
        }
        
        .chapter-select {
            background-color: var(--card-bg);
            border: 2px solid #444;
            color: #ffffff;
            border-radius: 6px;
            padding: 8px 12px;
            min-width: 200px;
            margin-bottom: 15px;
        }

        .chapter-select:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        
        .nav-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-nav {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-nav:hover {
            background-color: #e64a19;
            transform: translateY(-2px);
        }
        
        .btn-nav:disabled {
            background-color: #555;
            cursor: not-allowed;
            transform: none;
        }
        
        .page-info {
            text-align: center;
            color: #aaa;
            font-size: 14px;
        }
        
        /* Comic Reader */
        .comic-reader {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #333;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .comic-pages {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }
        
        .comic-page {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
        
        /* Page Navigation */
        .page-navigation {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        
        .page-btn {
            background-color: var(--card-bg);
            border: 1px solid #444;
            color: #ffffff;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 12px;
        }
        
        .page-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .page-btn.active {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        /* Comments Section */
        .comments-section {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 30px;
            margin: 20px 0;
            border: 1px solid #333;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .comments-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .comments-header h5 {
            color: var(--primary-color);
            margin: 0;
            margin-right: 10px;
        }

        .comment-form {
            background-color: var(--card-bg);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #444;
        }

        .comment-input {
            background-color: var(--darker-color);
            border: 1px solid #444;
            color: #ffffff;
            border-radius: 6px;
            padding: 12px;
            width: 100%;
            resize: vertical;
            min-height: 80px;
        }

        .comment-input:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .comment-item {
            background-color: var(--card-bg);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #444;
        }

        .comment-author {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 5px;
        }

        .comment-time {
            color: #aaa;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .comment-text {
            color: #ccc;
            line-height: 1.5;
        }
        
        @media (max-width: 768px) {
            .comic-header {
                padding: 20px;
            }
            
            .comic-cover {
                width: 150px;
                height: 210px;
            }
            
            .comic-title {
                font-size: 1.5rem;
            }
            
            .comic-subtitle {
                font-size: 1rem;
            }
            
            .action-buttons {
                justify-content: center;
            }
        }
        
        @media (max-width: 576px) {
            .comic-header {
                text-align: center;
            }
            
            .comic-meta {
                justify-content: center;
            }
            
            .nav-buttons {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
   <x-navbar></x-navbar>

    <div class="container">
        <!-- Comic Info Header -->
        <div class="comic-header">
            <div class="row">
                <div class="col-md-3 text-center mb-3">
                    <img src="{{$img}}" alt="omba ee" class="comic-cover">
                </div>
                <div class="col-md-9">
                    <h1 class="comic-title">{{$title}}</h1>

                    <h2 class="comic-subtitle">Chapter {{$chpTitle}}</h2>
                    
                    <div class="comic-meta">
                        <div class="meta-item">
                            <span class="meta-label">Status:</span>
                            <span class="meta-value">{{$status}}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Genre:</span>
                            <span class="meta-value">
                                <a href="{{ url('/genre/' . urlencode($genre)) }}" class="text-decoration-none text-white">
                                    {{ $genre }}
                                </a>
                            </span>
                        </div>

                        <div class="meta-item">
                            <span class="meta-label">Author:</span>
                            <span class="meta-value">{{$author}}</span>
                        </div>
                         <div class="meta-item">
                            <span class="meta-label">Uplouded:</span>
                            <span>{{$time}}</span>

                        </div>
                    </div>
                    
                    <div class="comic-description">
                        <p>{{$Deskr}}</p>
                        <!-- <p>test</p> -->
                    </div>
                    <div class="action-buttons">
                        <button class="btn-action btn-favorite" onclick="toggleFavorite()">
                            <i class="bi bi-heart me-2"></i>Favorite:{{ $favorite }}
                        </button>
                        <button class="btn-action btn-views">
                            <i class="bi bi-eye me-2"></i>2.5M Views
                        </button>
                        <button class="btn-action btn-rating">
                            <i class="bi bi-star-fill me-2"></i>{{$rate}} Rating
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chapter Navigation -->
        <div class="chapter-nav">
            <h5><i class="bi bi-list-ol"></i>Chapter Navigation</h5>
            <select class="chapter-select" id="chapterSelect" onchange="changeChapter()">
                <option value="178">Chapter 178: The Shadow Army</option>
                <option value="179">Chapter 179: Preparation for War</option>
                <option value="180" selected>Chapter 180: The Final Battle</option>
                <option value="181">Chapter 181: Coming Soon...</option>
            </select>
            <div class="nav-buttons">
                <button class="btn-nav" onclick="previousChapter()">
                    <i class="bi bi-chevron-left"></i> Previous
                </button>
                <button class="btn-nav" onclick="nextChapter()" disabled>
                    Next <i class="bi bi-chevron-right"></i>
                </button>
            </div>
            <div class="page-info">
                Chapter 180 of 180 • 25 pages
            </div>
        </div>

        <!-- Comic Reader -->
        <div class="comic-reader">
            <!-- Comic Pages -->
            <div class="comic-pages" id="comicPages">
                <!-- Pages will be loaded here -->
            </div>

            <!-- Bottom Page Navigation -->
            <div class="page-navigation">
                <button class="page-btn" onclick="previousPage()">
                    <i class="bi bi-chevron-left"></i> Previous Page
                </button>
                <span class="page-btn active" id="currentPageInfo">Page 1 of 25</span>
                <button class="page-btn" onclick="nextPage()">
                    Next Page <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="comments-section">
            <div class="comments-header">
                <h5><i class="bi bi-chat-dots me-2"></i>Comments</h5>
                <span class="badge bg-secondary">142 comments</span>
            </div>

            <!-- Comment Form -->
            <div class="comment-form">
                <textarea class="comment-input" placeholder="Tulis komentar Anda tentang chapter ini..." id="commentText"></textarea>
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn-nav" onclick="postComment()">
                        <i class="bi bi-send me-2"></i>Post Comment
                    </button>
                </div>
            </div>

            <!-- Comments List -->
            <div id="commentsList">
                <div class="comment-item">
                    <div class="comment-author">
                        <i class="bi bi-person-circle me-2"></i>Otaku_Master
                    </div>
                    <div class="comment-time">2 hours ago</div>
                    <div class="comment-text">
                        Chapter ini benar-benar epic! Jin-Woo sudah sangat kuat sekarang. Tidak sabar menunggu chapter selanjutnya!
                    </div>
                </div>

                <div class="comment-item">
                    <div class="comment-author">
                        <i class="bi bi-person-circle me-2"></i>MangaLover99
                    </div>
                    <div class="comment-time">3 hours ago</div>
                    <div class="comment-text">
                        Art style-nya semakin bagus! Shadow Army-nya Jin-Woo terlihat sangat menakutkan di chapter ini.
                    </div>
                </div>

                <div class="comment-item">
                    <div class="comment-author">
                        <i class="bi bi-person-circle me-2"></i>Hunter_Fan
                    </div>
                    <div class="comment-time">5 hours ago</div>
                    <div class="comment-text">
                        Akhirnya! Chapter yang sudah ditunggu-tunggu. Pertarungan final ini pasti akan sangat seru!
                    </div>
                </div>
            </div>

            <div class="text-center mt-3">
                <button class="btn-nav" onclick="loadMoreComments()">
                    <i class="bi bi-arrow-down me-2"></i>Load More Comments
                </button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sample comic pages data
        const comicPages = [
            'https://example.com/comic/page1.jpg',
            'https://example.com/comic/page2.jpg',
            'https://example.com/comic/page3.jpg',
            // Add more page URLs as needed
        ];
        // Initialize comic reader
        function initializeReader() {
            loadComicPages();
            updatePageInfo();
        }

        // Load comic pages
        function loadComicPages() {
            const pagesContainer = document.getElementById('comicPages');
            pagesContainer.innerHTML = '';

            comicPages.forEach((page, index) => {
                const img = document.createElement('img');
                img.src = page;
                img.alt = `Page ${index + 1}`;
                img.className = 'comic-page';
                pagesContainer.appendChild(img);
            });
        }

        // Update page info
        function updatePageInfo() {
            document.getElementById('currentPageInfo').textContent = `Page ${currentPage} of ${totalPages}`;
        }

        // Navigation functions
        function previousPage() {
            if (currentPage > 1) {
                currentPage--;
                updatePageInfo();
                window.scrollTo(0, 0);
            }
        }

        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                updatePageInfo();
                window.scrollTo(0, 0);
            }
        }

        // Chapter navigation
        function previousChapter() {
            alert('Loading previous chapter...');
        }

        function nextChapter() {
            alert('Next chapter not available yet.');
        }

        // Chapter navigation
        function changeChapter() {
            const chapter = document.getElementById('chapterSelect').value;
            alert(`Loading Chapter ${chapter}...`);
        }

        // Action functions
        function toggleFavorite() {
            const btn = document.querySelector('.btn-favorite');
            const icon = btn.querySelector('i');
            
            if (icon.classList.contains('bi-heart')) {
                icon.className = 'bi bi-heart-fill me-2';
                btn.style.backgroundColor = '#c2185b';
                alert('Added to favorites!');
            } else {
                icon.className = 'bi bi-heart me-2';
                btn.style.backgroundColor = '#e91e63';
                alert('Removed from favorites!');
            }
        }

        // Comment functions
        function postComment() {
            const commentText = document.getElementById('commentText').value.trim();
            if (!commentText) {
                alert('Please write a comment first!');
                return;
            }

            const commentsList = document.getElementById('commentsList');
            const newComment = document.createElement('div');
            newComment.className = 'comment-item';
            newComment.innerHTML = `
                <div class="comment-author">
                    <i class="bi bi-person-circle me-2"></i>You
                </div>
                <div class="comment-time">Just now</div>
                <div class="comment-text">${commentText}</div>
            `;
            
            commentsList.insertBefore(newComment, commentsList.firstChild);
            document.getElementById('commentText').value = '';
            alert('Comment posted successfully!');
        }

        function loadMoreComments() {
            alert('Loading more comments...');
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', initializeReader);
    </script>
</body>
</html>
