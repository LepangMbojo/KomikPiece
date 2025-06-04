<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorit | KomikKu</title>
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
        
        .navbar-custom {
            background-color: var(--dark-color);
            padding: 8px 0;
            border-bottom: 1px solid #333;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .back-link {
            color: #aaa;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: var(--primary-color);
        }
        
        /* User Profile Section */
        .user-profile {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 30px;
            margin: 20px 0;
            border: 1px solid #333;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #444;
        }
        
        .profile-info h2 {
            color: #ffffff;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        
        .profile-info p {
            color: #aaa;
            margin-bottom: 20px;
        }
        
        .profile-tabs {
            display: flex;
            gap: 10px;
        }
        
        .tab-btn {
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        
        .tab-btn.active {
            background-color: var(--primary-color);
            color: white;
        }
        
        .tab-btn:not(.active) {
            background-color: var(--card-bg);
            color: #aaa;
            border: 1px solid #444;
        }
        
        .tab-btn:not(.active):hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        /* Favorites Section */
        .favorites-section {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 30px;
            margin: 20px 0;
            border: 1px solid #333;
        }
        
        .section-title {
            color: var(--primary-color);
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 10px;
        }
        
        .comics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
        }
        
        .comic-card {
            background-color: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s;
            cursor: pointer;
            border: 1px solid #444;
        }
        
        .comic-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
        }
        
        .comic-cover {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        
        .comic-info {
            padding: 15px;
        }
        
        .comic-title {
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .comic-meta {
            font-size: 12px;
            color: #aaa;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #aaa;
        }
        
        .empty-state i {
            font-size: 3rem;
            color: #555;
            margin-bottom: 20px;
        }
        
        .empty-state h4 {
            color: #ffffff;
            margin-bottom: 10px;
        }
        
        @media (max-width: 768px) {
            .user-profile {
                padding: 20px;
                text-align: center;
            }
            
            .profile-avatar {
                width: 100px;
                height: 100px;
            }
            
            .profile-info h2 {
                font-size: 1.5rem;
            }
            
            .profile-tabs {
                justify-content: center;
                flex-wrap: wrap;
            }
            
            .comics-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
            }
            
            .comic-cover {
                height: 220px;
            }
        }
        
        @media (max-width: 576px) {
            .comics-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
            
            .comic-cover {
                height: 200px;
            }
            
            .comic-info {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="dashboard-dark-boxes.html">
                <i class="bi bi-book me-2"></i>KomikKu
            </a>
            <a href="dashboard-dark-boxes.html" class="back-link">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <div class="container">
        <!-- User Profile Section -->
        <div class="user-profile">
            <div class="row align-items-center">
                <div class="col-md-3 text-center mb-3">
                    <img src="https://via.placeholder.com/120x120/FF5722/FFFFFF?text=User" alt="Profile" class="profile-avatar">
                </div>
                <div class="col-md-9">
                    <div class="profile-info">
                        <h2>Dou_Mbojo</h2>
                        <p>Bergabung: 5 tahun, 3 bulan yang lalu</p>
                        
                        <div class="profile-tabs">
                            <button class="tab-btn active" onclick="switchTab('favorites')">
                                <i class="bi bi-heart-fill me-2"></i>Favorites
                            </button>
                            <button class="tab-btn" onclick="switchTab('settings')">
                                <i class="bi bi-gear me-2"></i>Settings
                            </button>
                            <button class="tab-btn" onclick="switchTab('history')">
                                <i class="bi bi-clock-history me-2"></i>History
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Favorites Section -->
        <div class="favorites-section" id="favoritesSection">
            <h3 class="section-title">
                <i class="bi bi-heart-fill"></i>
                Recent Favorites
            </h3>
            
            <div class="comics-grid" id="comicsGrid">
                <!-- Comics will be loaded here -->
            </div>
            
            <!-- Empty State -->
            <div class="empty-state d-none" id="emptyState">
                <i class="bi bi-heart"></i>
                <h4>Belum Ada Favorit</h4>
                <p>Mulai tambahkan komik ke favorit Anda!</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sample favorite comics data
        const favoriteComics = [
            {
                id: 1,
                title: "Solo Leveling",
                cover: "https://via.placeholder.com/180x250/FF5722/FFFFFF?text=Solo+Leveling",
                chapter: "Ch. 180"
            },
            {
                id: 2,
                title: "One Piece",
                cover: "https://via.placeholder.com/180x250/2196F3/FFFFFF?text=One+Piece",
                chapter: "Ch. 1100"
            },
            {
                id: 3,
                title: "Demon Slayer",
                cover: "https://via.placeholder.com/180x250/9C27B0/FFFFFF?text=Demon+Slayer",
                chapter: "Ch. 205"
            },
            {
                id: 4,
                title: "Attack on Titan",
                cover: "https://via.placeholder.com/180x250/795548/FFFFFF?text=Attack+on+Titan",
                chapter: "Ch. 139"
            },
            {
                id: 5,
                title: "My Hero Academia",
                cover: "https://via.placeholder.com/180x250/4CAF50/FFFFFF?text=My+Hero+Academia",
                chapter: "Ch. 350"
            },
            {
                id: 6,
                title: "Jujutsu Kaisen",
                cover: "https://via.placeholder.com/180x250/E91E63/FFFFFF?text=Jujutsu+Kaisen",
                chapter: "Ch. 245"
            },
            {
                id: 7,
                title: "Chainsaw Man",
                cover: "https://via.placeholder.com/180x250/607D8B/FFFFFF?text=Chainsaw+Man",
                chapter: "Ch. 150"
            },
            {
                id: 8,
                title: "Black Clover",
                cover: "https://via.placeholder.com/180x250/3F51B5/FFFFFF?text=Black+Clover",
                chapter: "Ch. 280"
            }
        ];

        // Initialize page
        function initializePage() {
            displayComics();
        }

        // Display comics
        function displayComics() {
            const grid = document.getElementById('comicsGrid');
            const emptyState = document.getElementById('emptyState');

            if (favoriteComics.length === 0) {
                grid.style.display = 'none';
                emptyState.classList.remove('d-none');
                return;
            }

            grid.style.display = 'grid';
            emptyState.classList.add('d-none');

            grid.innerHTML = favoriteComics.map(comic => `
                <div class="comic-card" onclick="openComic(${comic.id})">
                    <img src="${comic.cover}" alt="${comic.title}" class="comic-cover">
                    <div class="comic-info">
                        <div class="comic-title">${comic.title}</div>
                        <div class="comic-meta">${comic.chapter}</div>
                    </div>
                </div>
            `).join('');
        }

        // Switch tabs
        function switchTab(tab) {
            // Update tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            // Handle tab content
            switch(tab) {
                case 'favorites':
                    document.getElementById('favoritesSection').style.display = 'block';
                    break;
                case 'settings':
                    document.getElementById('favoritesSection').style.display = 'none';
                    alert('Settings page - Coming soon!');
                    break;
                case 'history':
                    document.getElementById('favoritesSection').style.display = 'none';
                    alert('History page - Coming soon!');
                    break;
            }
        }

        // Open comic
        function openComic(comicId) {
            const comic = favoriteComics.find(c => c.id === comicId);
            alert(`Membuka komik: ${comic.title}`);
            // window.location.href = `comic-detail.html?id=${comicId}`;
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', initializePage);
    </script>
</body>
</html>
