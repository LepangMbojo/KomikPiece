<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User | Admin KomikKu</title>
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
        
        /* Admin Header */
        .admin-header {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 30px;
            margin: 20px 0;
            border: 1px solid #333;
        }
        
        .admin-title {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .admin-subtitle {
            color: #aaa;
            margin: 0;
        }
        
        /* Controls Section */
        .controls-section {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #333;
        }
        
        .controls-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .search-controls {
            display: flex;
            gap: 10px;
            flex: 1;
            min-width: 300px;
        }
        
        .search-input {
            background-color: var(--card-bg);
            border: 2px solid #444;
            color: #ffffff;
            border-radius: 6px;
            padding: 10px 15px;
            flex: 1;
        }
        
        .search-input:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        
        .search-input::placeholder {
            color: #888;
        }
        
        .filter-select {
            background-color: var(--card-bg);
            border: 2px solid #444;
            color: #ffffff;
            border-radius: 6px;
            padding: 10px 12px;
            min-width: 120px;
        }
        
        .filter-select:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #e64a19;
        }
        
        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-success:hover {
            background-color: #218838;
        }
        
        /* Users Table */
        .users-section {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 30px;
            margin: 20px 0;
            border: 1px solid #333;
        }
        
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table-dark {
            background-color: var(--card-bg);
            border: 1px solid #444;
        }
        
        .table-dark th {
            background-color: var(--dark-color);
            border-color: #444;
            color: var(--primary-color);
            font-weight: 600;
            padding: 15px 12px;
        }
        
        .table-dark td {
            border-color: #444;
            padding: 15px 12px;
            vertical-align: middle;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            object-fit: cover;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-name {
            font-weight: 600;
            color: #ffffff;
            margin: 0;
        }
        
        .user-email {
            font-size: 12px;
            color: #aaa;
            margin: 0;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-active {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid #28a745;
        }
        
        .status-inactive {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid #dc3545;
        }
        
        .status-banned {
            background-color: rgba(108, 117, 125, 0.2);
            color: #6c757d;
            border: 1px solid #6c757d;
        }
        
        .role-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .role-admin {
            background-color: rgba(255, 87, 34, 0.2);
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }
        
        .role-user {
            background-color: rgba(33, 150, 243, 0.2);
            color: #2196f3;
            border: 1px solid #2196f3;
        }
        
        .role-moderator {
            background-color: rgba(156, 39, 176, 0.2);
            color: #9c27b0;
            border: 1px solid #9c27b0;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .btn-sm {
            padding: 5px 8px;
            font-size: 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-info {
            background-color: #17a2b8;
            color: white;
        }
        
        .btn-info:hover {
            background-color: #138496;
        }
        
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }
        
        .btn-warning:hover {
            background-color: #e0a800;
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #c82333;
        }
        
        /* Pagination */
        .pagination-section {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-top: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .pagination-info {
            color: #aaa;
            font-size: 14px;
        }
        
        .pagination-controls {
            display: flex;
            gap: 5px;
        }
        
        .page-btn {
            background-color: var(--card-bg);
            border: 1px solid #444;
            color: #ffffff;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
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
        
        /* Modal Styles */
        .modal-content {
            background-color: var(--section-bg);
            border: 1px solid #444;
            border-radius: 12px;
        }
        
        .modal-header {
            border-bottom: 1px solid #444;
            background-color: var(--dark-color);
        }
        
        .modal-title {
            color: var(--primary-color);
            font-weight: bold;
        }
        
        .modal-body {
            background-color: var(--section-bg);
        }
        
        .modal-footer {
            border-top: 1px solid #444;
            background-color: var(--section-bg);
        }
        
        .form-label {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .form-control {
            background-color: var(--card-bg);
            border: 2px solid #444;
            border-radius: 6px;
            padding: 10px 12px;
            color: #ffffff;
        }
        
        .form-control:focus {
            background-color: var(--card-bg);
            border-color: var(--primary-color);
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(255, 87, 34, 0.25);
        }
        
        .form-control::placeholder {
            color: #888;
        }
        
        .form-select {
            background-color: var(--card-bg);
            border: 2px solid #444;
            color: #ffffff;
            border-radius: 6px;
        }
        
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 87, 34, 0.25);
        }
        
        .btn-close {
            filter: invert(1);
        }
        
        @media (max-width: 768px) {
            .admin-header {
                padding: 20px;
                text-align: center;
            }
            
            .admin-title {
                font-size: 1.5rem;
            }
            
            .controls-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-controls {
                min-width: 100%;
                flex-direction: column;
            }
            
            .table-responsive {
                font-size: 14px;
            }
            
            .user-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="dashboard-dark-boxes.html">
                <i class="bi bi-shield-check me-2"></i>Admin KomikKu
            </a>
            <a href="dashboard-dark-boxes.html" class="back-link">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <div class="container">
        <!-- Admin Header -->
        <div class="admin-header">
            <h1 class="admin-title">
                <i class="bi bi-people-fill me-2"></i>Kelola User
            </h1>
            <p class="admin-subtitle">Kelola semua user yang terdaftar di sistem</p>
        </div>

        <!-- Controls Section -->
        <div class="controls-section">
            <div class="controls-row">
                <div class="search-controls">
                    <input type="text" class="search-input" placeholder="Cari user berdasarkan nama atau email..." id="searchInput">
                    <select class="filter-select" id="roleFilter">
                        <option value="all">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="moderator">Moderator</option>
                        <option value="user">User</option>
                    </select>
                    <select class="filter-select" id="statusFilter">
                        <option value="all">Semua Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="banned">Banned</option>
                    </select>
                </div>
                <div class="action-controls">
                    <button class="btn btn-success" onclick="openAddUserModal()">
                        <i class="bi bi-person-plus me-2"></i>Tambah User
                    </button>
                    <button class="btn btn-primary" onclick="exportUsers()">
                        <i class="bi bi-download me-2"></i>Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Users Table Section -->
        <div class="users-section">
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <!-- Users will be loaded here -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-section">
                <div class="pagination-info" id="paginationInfo">
                    Menampilkan 1-10 dari 156 user
                </div>
                <div class="pagination-controls" id="paginationControls">
                    <button class="page-btn" onclick="changePage(1)">1</button>
                    <button class="page-btn active" onclick="changePage(2)">2</button>
                    <button class="page-btn" onclick="changePage(3)">3</button>
                    <button class="page-btn" onclick="changePage(4)">4</button>
                    <button class="page-btn" onclick="changePage(5)">5</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalTitle">Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">Nama Depan</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Nama Belakang</label>
                                <input type="text" class="form-control" id="lastName" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="user">User</option>
                                    <option value="moderator">Moderator</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="banned">Banned</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3" id="passwordSection">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Minimal 8 karakter">
                        </div>
                        <input type="hidden" id="userId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveUser()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus user <strong id="deleteUserName"></strong>?</p>
                    <p class="text-warning">Tindakan ini tidak dapat dibatalkan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sample users data
        let users = [
            {
                id: 1,
                firstName: "John",
                lastName: "Doe",
                username: "johndoe",
                email: "john@example.com",
                role: "admin",
                status: "active",
                joinDate: "2023-01-15",
                avatar: "https://via.placeholder.com/40x40/FF5722/FFFFFF?text=JD"
            },
            {
                id: 2,
                firstName: "Jane",
                lastName: "Smith",
                username: "janesmith",
                email: "jane@example.com",
                role: "moderator",
                status: "active",
                joinDate: "2023-02-20",
                avatar: "https://via.placeholder.com/40x40/2196F3/FFFFFF?text=JS"
            },
            {
                id: 3,
                firstName: "Bob",
                lastName: "Johnson",
                username: "bobjohnson",
                email: "bob@example.com",
                role: "user",
                status: "inactive",
                joinDate: "2023-03-10",
                avatar: "https://via.placeholder.com/40x40/4CAF50/FFFFFF?text=BJ"
            },
            {
                id: 4,
                firstName: "Alice",
                lastName: "Brown",
                username: "alicebrown",
                email: "alice@example.com",
                role: "user",
                status: "active",
                joinDate: "2023-04-05",
                avatar: "https://via.placeholder.com/40x40/9C27B0/FFFFFF?text=AB"
            },
            {
                id: 5,
                firstName: "Charlie",
                lastName: "Wilson",
                username: "charliewilson",
                email: "charlie@example.com",
                role: "user",
                status: "banned",
                joinDate: "2023-05-12",
                avatar: "https://via.placeholder.com/40x40/FF9800/FFFFFF?text=CW"
            }
        ];

        let filteredUsers = [...users];
        let currentPage = 1;
        let editingUserId = null;

        // Initialize page
        function initializePage() {
            displayUsers();
            setupEventListeners();
        }

        // Setup event listeners
        function setupEventListeners() {
            document.getElementById('searchInput').addEventListener('input', filterUsers);
            document.getElementById('roleFilter').addEventListener('change', filterUsers);
            document.getElementById('statusFilter').addEventListener('change', filterUsers);
        }

        // Display users in table
        function displayUsers() {
            const tbody = document.getElementById('usersTableBody');
            
            tbody.innerHTML = filteredUsers.map(user => `
                <tr>
                    <td>#${user.id}</td>
                    <td>
                        <div class="user-info">
                            <img src="${user.avatar}" alt="${user.firstName}" class="user-avatar">
                            <div>
                                <div class="user-name">${user.firstName} ${user.lastName}</div>
                                <div class="user-email">${user.email}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge role-${user.role}">${getRoleText(user.role)}</span>
                    </td>
                    <td>
                        <span class="status-badge status-${user.status}">${getStatusText(user.status)}</span>
                    </td>
                    <td>${formatDate(user.joinDate)}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-info btn-sm" onclick="viewUser(${user.id})" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-warning btn-sm" onclick="editUser(${user.id})" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Filter users
        function filterUsers() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const roleFilter = document.getElementById('roleFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;

            filteredUsers = users.filter(user => {
                const matchesSearch = user.firstName.toLowerCase().includes(searchTerm) ||
                                    user.lastName.toLowerCase().includes(searchTerm) ||
                                    user.email.toLowerCase().includes(searchTerm) ||
                                    user.username.toLowerCase().includes(searchTerm);
                
                const matchesRole = roleFilter === 'all' || user.role === roleFilter;
                const matchesStatus = statusFilter === 'all' || user.status === statusFilter;

                return matchesSearch && matchesRole && matchesStatus;
            });

            displayUsers();
            updatePaginationInfo();
        }

        // Get role text
        function getRoleText(role) {
            const roleTexts = {
                'admin': 'Admin',
                'moderator': 'Moderator',
                'user': 'User'
            };
            return roleTexts[role] || role;
        }

        // Get status text
        function getStatusText(status) {
            const statusTexts = {
                'active': 'Aktif',
                'inactive': 'Tidak Aktif',
                'banned': 'Banned'
            };
            return statusTexts[status] || status;
        }

        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        }

        // Update pagination info
        function updatePaginationInfo() {
            const info = document.getElementById('paginationInfo');
            info.textContent = `Menampilkan 1-${filteredUsers.length} dari ${users.length} user`;
        }

        // Open add user modal
        function openAddUserModal() {
            editingUserId = null;
            document.getElementById('userModalTitle').textContent = 'Tambah User Baru';
            document.getElementById('userForm').reset();
            document.getElementById('passwordSection').style.display = 'block';
            document.getElementById('password').required = true;
            
            const modal = new bootstrap.Modal(document.getElementById('userModal'));
            modal.show();
        }

        // View user
        function viewUser(userId) {
            const user = users.find(u => u.id === userId);
            alert(`Detail User:\n\nNama: ${user.firstName} ${user.lastName}\nEmail: ${user.email}\nUsername: ${user.username}\nRole: ${getRoleText(user.role)}\nStatus: ${getStatusText(user.status)}\nBergabung: ${formatDate(user.joinDate)}`);
        }

        // Edit user
        function editUser(userId) {
            const user = users.find(u => u.id === userId);
            if (!user) return;

            editingUserId = userId;
            document.getElementById('userModalTitle').textContent = 'Edit User';
            document.getElementById('firstName').value = user.firstName;
            document.getElementById('lastName').value = user.lastName;
            document.getElementById('email').value = user.email;
            document.getElementById('username').value = user.username;
            document.getElementById('role').value = user.role;
            document.getElementById('status').value = user.status;
            document.getElementById('userId').value = user.id;
            
            // Hide password field for editing
            document.getElementById('passwordSection').style.display = 'none';
            document.getElementById('password').required = false;

            const modal = new bootstrap.Modal(document.getElementById('userModal'));
            modal.show();
        }

        // Save user
        function saveUser() {
            const form = document.getElementById('userForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const userData = {
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                email: document.getElementById('email').value,
                username: document.getElementById('username').value,
                role: document.getElementById('role').value,
                status: document.getElementById('status').value
            };

            if (editingUserId) {
                // Update existing user
                const userIndex = users.findIndex(u => u.id === editingUserId);
                if (userIndex !== -1) {
                    users[userIndex] = { ...users[userIndex], ...userData };
                }
            } else {
                // Add new user
                const newUser = {
                    id: Math.max(...users.map(u => u.id)) + 1,
                    ...userData,
                    joinDate: new Date().toISOString().split('T')[0],
                    avatar: `https://via.placeholder.com/40x40/FF5722/FFFFFF?text=${userData.firstName.charAt(0)}${userData.lastName.charAt(0)}`
                };
                users.push(newUser);
            }

            filterUsers();
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('userModal'));
            modal.hide();
            
            alert(editingUserId ? 'User berhasil diupdate!' : 'User berhasil ditambahkan!');
        }

        // Delete user
        function deleteUser(userId) {
            const user = users.find(u => u.id === userId);
            if (!user) return;

            document.getElementById('deleteUserName').textContent = `${user.firstName} ${user.lastName}`;
            
            // Store user ID for deletion
            window.userToDelete = userId;
            
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Confirm delete
        function confirmDelete() {
            const userId = window.userToDelete;
            users = users.filter(u => u.id !== userId);
            filterUsers();
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            modal.hide();
            
            alert('User berhasil dihapus!');
        }

        // Change page
        function changePage(page) {
            currentPage = page;
            
            // Update pagination buttons
            document.querySelectorAll('.page-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        // Export users
        function exportUsers() {
            const csvContent = "data:text/csv;charset=utf-8," 
                + "ID,Nama Depan,Nama Belakang,Username,Email,Role,Status,Tanggal Bergabung\n"
                + users.map(user => 
                    `${user.id},${user.firstName},${user.lastName},${user.username},${user.email},${user.role},${user.status},${user.joinDate}`
                ).join("\n");

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "users_export.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', initializePage);
    </script>
</body>
</html>
