 
 
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
        }
        
        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .search-btn {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            margin-right: 15px;
        }
        
        .search-btn:hover {
            background-color: #e64a19;
        }
        
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 25px;
            margin: 0 20px;
        }
        
        .nav-menu a {
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
            padding: 5px 0;
        }
        
        .nav-menu a:hover,
        .nav-menu a.active {
            color: var(--primary-color);
        }
        
        .right-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .auth-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-login {
            background: transparent;
            border: 1px solid #555;
            color: #ffffff;
            padding: 6px 15px;
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-register {
            background-color: var(--primary-color);
            border: 1px solid var(--primary-color);
            color: white;
            padding: 6px 15px;
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .btn-register:hover {
            background-color: #e64a19;
            border-color: #e64a19;
        }
    
</style>

 <nav class="navbar-custom">
        <div class="container-fluid">
            <div class="d-flex align-items-center w-100">
                <!-- Logo -->
                <a class="navbar-brand" href="/">
                    <i class="bi bi-book me-1"></i>KomikPiece
                </a>
                
                <!-- Search Button -->
           <div class="search-bar" id="searchBar">
                <div class="container">
                    <form action="{{ url('/KomIndex/search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control search-input" placeholder="Cari komik..." id="searchInput">
                            <button class="btn btn-outline-light" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

                            
                <!-- Navigation Menu -->
                <div class="nav-menu">
                    <a href="#" class="active" onclick="loadPage('popular')">Populer</a>
                    <a href="#" onclick="loadPage('genres')">Genres</a>
                    <a href="" onclick="loadPage('info')">Info</a>
                </div>
                
                <!-- Right Menu -->
                <div class="right-menu ms-auto">
                    <!-- Auth Buttons -->
                    <div class="auth-buttons">
                        <button class="btn-login" onclick="showLogin()">
                            <i class="bi bi-box-arrow-in-right me-1"></i>log in
                        </button>
                        <button class="btn-register" onclick="showRegister()">
                            <i class="bi bi-person-plus me-1"></i>Register
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>  
    // Search functionality
        function toggleSearch() {
            const searchBar = document.getElementById('searchBar');
            if (searchBar.style.display === 'none' || searchBar.style.display === '') {
                searchBar.style.display = 'block';
                document.getElementById('searchInput').focus();
            } else {
                searchBar.style.display = 'none';
            }
        }

        function performSearch() {
            const query = document.getElementById('searchInput').value.trim();
            if (query) {
                alert(`Mencari: ${query}`);
                document.getElementById('searchBar').style.display = 'none';
            }
        }

        // Auth functions
        function showLogin() {
            window.location.href = '/login';
        }

        function showRegister() {
            window.location.href = '/register';
        }

        // Search on Enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    </script>