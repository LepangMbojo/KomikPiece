<nav class="navbar-custom">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-book me-2"></i>{{ config('app.name', 'KomikPiece') }}
            </a>

            <!-- Navigation Menu -->
            <div class="nav-menu d-flex align-items-center gap-3">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door me-1"></i>Home
                </a>
                <a href="{{route('genre.index')}}" class="{{ request()->routeIs('genre.index') ? 'active' : '' }}">
                    <i class="bi bi-grid me-1"></i>Genres
                </a>

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
                            <i class="bi bi-shield-check me-1"></i>Admin Panel
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Right Side Menu -->
            <div class="right-menu d-flex align-items-center gap-2">
                <!-- Search Button -->
                <button class="search-btn" onclick="toggleSearch()">
                    <i class="bi bi-search"></i>
                </button>

                <!-- Auth Buttons -->
                @auth
                    <div class="dropdown">
                        <button class="btn-login dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                            @if(Auth::user()->isAdmin())
                                <span class="badge bg-danger ms-1">Admin</span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="background-color: var(--card-bg); border: 1px solid #444;">
                            <li>
                                <a class="dropdown-item text-white" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person-gear me-2"></i>Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-white" href="{{ route('favorites.index') }}">
                                    <i class="bi bi-heart me-2"></i>Favorites
                                </a>
                            </li>
                            @if(Auth::user()->isAdmin())
                                <li><hr class="dropdown-divider" style="border-color: #444;"></li>
                                <li>
                                    <a class="dropdown-item text-white" href="{{ route('admin.comics') }}">
                                        <i class="bi bi-book me-2"></i>Manage Comics
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-white" href="{{ route('admin.users') }}">
                                        <i class="bi bi-people me-2"></i>Manage Users
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider" style="border-color: #444;"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-white">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn-login">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn-register">
                            <i class="bi bi-person-plus me-1"></i>Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Search Bar -->
        <div id="searchBar" style="display: none; margin-top: 10px;">
            <form class="input-group" action="{{ route('komik.search') }}" method="GET">
                <input type="text" class="form-control search-input" id="searchInput" name="q" placeholder="Search for comics..." value="{{ request('q') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>
</nav>




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

    // Search on Enter key
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });
        }
    });
</script>
