<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">Admin Dashboard</h2>
            <span class="badge bg-danger">Admin Panel</span>
        </div>
    </x-slot>

    <div class="container py-4">
        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Total Komik</h5>
                                <h2 class="mb-0">{{ $totalComics }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-book fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Total Users</h5>
                                <h2 class="mb-0">{{ $totalUsers }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-people fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Total Admins</h5>
                                <h2 class="mb-0">{{ $totalAdmins }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-shield-check fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Quick Actions</h5>
                                <a href="{{ route('admin.comics.create') }}" class="btn btn-light btn-sm">
                                    <i class="bi bi-plus"></i> Add Comic
                                </a>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-lightning fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="section-container mb-4">
            <div class="section-header">
                <i class="bi bi-lightning"></i>
                <span>Quick Actions</span>
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <a href="{{ route('admin.comics') }}" class="btn btn-primary w-100">
                        <i class="bi bi-book me-2"></i>Manage Comics
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.users') }}" class="btn btn-success w-100">
                        <i class="bi bi-people me-2"></i>Manage Users
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.comics.create') }}" class="btn btn-warning w-100">
                        <i class="bi bi-plus me-2"></i>Add New Comic
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('index') }}" class="btn btn-info w-100">
                        <i class="bi bi-eye me-2"></i>View Site
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Comics -->
        <div class="section-container mb-4">
            <div class="section-header">
                <i class="bi bi-clock-history"></i>
                <span>Recent Comics</span>
                <div class="ms-auto">
                    <a href="{{ route('admin.comics') }}" class="btn btn-outline-light btn-sm">
                        View All
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentComics as $comic)
                            <tr>
                                <td>
                                    <<img src="{{ Storage::url($comic->cover) }}" 
                                         alt="{{ $comic->judul }}" 
                                         style="width: 40px; height: 60px; object-fit: cover;">
                                </td>
                                <td>{{ $comic->judul }}</td>
                                <td>{{ $comic->author ?? 'Unknown' }}</td>
                                <td>
                                    <span class="badge bg-{{ $comic->status == 'ongoing' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($comic->status ?? 'ongoing') }}
                                    </span>
                                </td>
                                <td>{{ $comic->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No comics found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="section-container">
            <div class="section-header">
                <i class="bi bi-people"></i>
                <span>Recent Users</span>
                <div class="ms-auto">
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-light btn-sm">
                        View All
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No users found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>