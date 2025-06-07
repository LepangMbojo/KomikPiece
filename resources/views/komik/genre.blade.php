<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genre | KomikKu</title>
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
        
        /* Page Header */
        .page-header {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 30px;
            margin: 20px 0;
            border: 1px solid #333;
            text-align: center;
        }
        
        .page-title {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .page-subtitle {
            color: #aaa;
            margin: 0;
        }
        
        /* Genre Grid */
        .genres-section {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 30px;
            margin: 20px 0;
            border: 1px solid #333;
        }
        
        .genres-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .genre-card {
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            border: 1px solid #444;
        }
        
        .genre-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
        }
        
        .genre-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .genre-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 10px;
        }
        
        .genre-count {
            color: #aaa;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .page-header {
                padding: 20px;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .genres-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
            }
            
            .genre-card {
                padding: 15px;
            }
            
            .genre-icon {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 576px) {
            .genres-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
            
            .genre-card {
                padding: 15px;
            }
            
            .genre-name {
                font-size: 1rem;
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
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="bi bi-tags-fill me-2"></i>Genre Komik
            </h1>
            <p class="page-subtitle">Pilih genre komik favorit Anda</p>
        </div>

        <!-- Genres Section -->
        <div class="genres-section">
            <div class="genres-grid" id="genresGrid">
                <!-- Genres will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Simple genre data
        const genres = [
            { name: 'Action', icon: 'bi-lightning-charge-fill', count: '1,250 komik' },
            { name: 'Romance', icon: 'bi-heart-fill', count: '890 komik' },
            { name: 'Comedy', icon: 'bi-emoji-laughing-fill', count: '675 komik' },
            { name: 'Drama', icon: 'bi-mask-fill', count: '543 komik' },
            { name: 'Fantasy', icon: 'bi-magic', count: '789 komik' },
            { name: 'Horror', icon: 'bi-ghost', count: '234 komik' },
            { name: 'Mystery', icon: 'bi-search', count: '456 komik' },
            { name: 'Sci-Fi', icon: 'bi-rocket-takeoff-fill', count: '321 komik' },
            { name: 'Slice of Life', icon: 'bi-house-heart-fill', count: '567 komik' },
            { name: 'Sports', icon: 'bi-trophy-fill', count: '298 komik' },
            { name: 'Supernatural', icon: 'bi-eye-fill', count: '445 komik' },
            { name: 'Thriller', icon: 'bi-exclamation-triangle-fill', count: '387 komik' }
        ];

        // Load genres
        function loadGenres() {
            const container = document.getElementById('genresGrid');
            
            container.innerHTML = genres.map(genre => `
                <div class="genre-card" onclick="openGenre('${genre.name}')">
                    <i class="${genre.icon} genre-icon"></i>
                    <div class="genre-name">${genre.name}</div>
                    <div class="genre-count">${genre.count}</div>
                </div>
            `).join('');
        }

        // Open genre
        function openGenre(genreName) {
            alert(`Membuka genre: ${genreName}`);
            // window.location.href = `genre-detail.html?genre=${genreName}`;
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', loadGenres);
    </script>
</body>
</html>
